<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ImportController extends Controller
{
    public function importCSV(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'csv_file' => 'required|file|mimes:csv,txt|max:10240', // 10MB max
            'niveau' => 'required|in:prescolaire,primaire,college,lycee'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Fichier invalide: ' . $validator->errors()->first()
            ], 422);
        }

        try {
            $file = $request->file('csv_file');
            $niveau = $request->input('niveau');
            
            Log::info("Tentative d'import CSV", [
                'niveau' => $niveau,
                'fichier' => $file->getClientOriginalName(),
                'taille' => $file->getSize()
            ]);
            
            // Sauvegarder le fichier
            $fileName = $niveau . '_' . time() . '.csv';
            $filePath = $file->storeAs('imports', $fileName, 'public');
            
            // Traiter le fichier CSV
            $etablissements = $this->processCSV(storage_path('app/public/' . $filePath));
            
            // Mettre à jour le fichier de données correspondant
            $this->updateDataFile($niveau, $etablissements);
            
            Log::info("Import réussi", [
                'niveau' => $niveau,
                'etablissements' => count($etablissements),
                'fichier' => $fileName
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Import réussi! ' . count($etablissements) . ' établissements importés.',
                'etablissements' => $etablissements,
                'count' => count($etablissements)
            ]);
            
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'import", [
                'niveau' => $niveau ?? 'inconnu',
                'erreur' => $e->getMessage(),
                'fichier' => $file->getClientOriginalName() ?? 'inconnu'
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du traitement: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function downloadTemplate($niveau)
    {
        $niveauxValides = ['prescolaire', 'primaire', 'college', 'lycee'];
        
        if (!in_array($niveau, $niveauxValides)) {
            return response()->json([
                'success' => false,
                'message' => 'Niveau invalide'
            ], 422);
        }
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=template_{$niveau}.csv",
        ];
        
        $template = $this->generateTemplate($niveau);
        
        return response($template, 200, $headers);
    }
    
    private function generateTemplate($niveau)
    {
        $headers = "nom_etab;cisco;commune;secteur;nb_enf;nb_ens_foncts;x;y\n";
        
        // Exemple de données
        $examples = [
            "ECOLE MATERNELLE EXEMPLE;AMBATOLAMPY;AMBATOLAMPY;Publique;45;5;47.44513;-19.3741",
            "JARDIN D'ENFANTS MODÈLE;ANTANIFOTSY;ANTANIFOTSY;Privée;30;3;47.43843;-19.40372"
        ];
        
        return $headers . implode("\n", $examples);
    }
    
    private function processCSV($filePath)
    {
        $etablissements = [];
        
        if (!file_exists($filePath)) {
            throw new \Exception("Fichier non trouvé: " . $filePath);
        }
        
        $handle = fopen($filePath, 'r');
        
        if ($handle === false) {
            throw new \Exception("Impossible d'ouvrir le fichier: " . $filePath);
        }
        
        try {
            // Détecter le séparateur
            $separator = $this->detectSeparator($filePath);
            
            // Lire l'en-tête
            $headers = fgetcsv($handle, 1000, $separator);
            if ($headers === false) {
                throw new \Exception("Impossible de lire l'en-tête du fichier");
            }
            
            $headers = array_map('trim', array_map('strtolower', $headers));
            
            $lineNumber = 1;
            while (($data = fgetcsv($handle, 1000, $separator)) !== false) {
                $lineNumber++;
                
                // Ignorer les lignes vides
                if (count($data) === 1 && empty(trim($data[0]))) {
                    continue;
                }
                
                $etab = [];
                
                foreach ($headers as $index => $header) {
                    $value = $data[$index] ?? '';
                    $value = trim($value);
                    
                    // Nettoyer et convertir les valeurs
                    switch($header) {
                        case 'nom_etab':
                        case 'nom':
                            $etab['nom'] = $value;
                            break;
                        case 'cisco':
                            $etab['cisco'] = $value;
                            break;
                        case 'commune':
                            $etab['commune'] = $value;
                            break;
                        case 'secteur':
                            $etab['secteur'] = $value;
                            break;
                        case 'nb_enf':
                        case 'eleves':
                        case 'effectif':
                            $etab['eleves'] = $this->parseNumber($value);
                            break;
                        case 'nb_ens_foncts':
                        case 'personnel':
                        case 'enseignants':
                            $etab['personnel'] = $this->parseNumber($value);
                            break;
                        case 'x':
                        case 'longitude':
                            $etab['x'] = $this->parseCoordinate($value);
                            break;
                        case 'y':
                        case 'latitude':
                            $etab['y'] = $this->parseCoordinate($value);
                            break;
                        default:
                            $etab[$header] = $value;
                    }
                }
                
                // S'assurer des champs requis
                $etab['nom'] = $etab['nom'] ?? 'Établissement ' . (count($etablissements) + 1);
                $etab['cisco'] = $etab['cisco'] ?? 'INCONNU';
                $etab['commune'] = $etab['commune'] ?? 'INCONNU';
                $etab['secteur'] = $etab['secteur'] ?? 'Publique';
                $etab['eleves'] = $etab['eleves'] ?? 0;
                $etab['personnel'] = $etab['personnel'] ?? 0;
                $etab['x'] = $etab['x'] ?? null;
                $etab['y'] = $etab['y'] ?? null;
                
                $etablissements[] = $etab;
            }
        } finally {
            fclose($handle);
        }
        
        if (count($etablissements) === 0) {
            throw new \Exception("Aucune donnée valide trouvée dans le fichier CSV");
        }
        
        return $etablissements;
    }
    
    private function parseNumber($value)
    {
        if (empty($value)) return 0;
        
        // Remplacer les virgules par des points pour les nombres
        $value = str_replace(',', '.', $value);
        
        // Supprimer les espaces et caractères non numériques (sauf le point décimal)
        $value = preg_replace('/[^\d.-]/', '', $value);
        
        return intval(floatval($value));
    }
    
    private function parseCoordinate($value)
    {
        if (empty($value)) return null;
        
        // Remplacer les virgules par des points pour les coordonnées
        $value = str_replace(',', '.', $value);
        
        // Nettoyer la valeur
        $value = preg_replace('/[^\d.-]/', '', $value);
        
        $floatValue = floatval($value);
        
        // Vérifier si c'est une coordonnée valide pour Madagascar
        if (abs($floatValue) > 0 && abs($floatValue) < 180) {
            return $floatValue;
        }
        
        return null;
    }
    
    private function detectSeparator($filePath)
    {
        $firstLine = file($filePath)[0] ?? '';
        return strpos($firstLine, ';') !== false ? ';' : ',';
    }
    
    private function updateDataFile($niveau, $etablissements)
    {
        $fileName = $this->getFileNameForLevel($niveau);
        $filePath = public_path("data/{$fileName}");
        
        // Créer le dossier s'il n'existe pas
        if (!file_exists(dirname($filePath))) {
            mkdir(dirname($filePath), 0755, true);
        }
        
        $handle = fopen($filePath, 'w');
        
        if ($handle === false) {
            throw new \Exception("Impossible de créer le fichier: " . $filePath);
        }
        
        try {
            // Écrire l'en-tête
            fputcsv($handle, [
                'nom_etab', 'cisco', 'commune', 'secteur', 'nb_enf', 'nb_ens_foncts', 'x', 'y'
            ], ';');
            
            // Écrire les données
            foreach ($etablissements as $etab) {
                fputcsv($handle, [
                    $etab['nom'] ?? '',
                    $etab['cisco'] ?? '',
                    $etab['commune'] ?? '',
                    $etab['secteur'] ?? '',
                    $etab['eleves'] ?? 0,
                    $etab['personnel'] ?? 0,
                    $etab['x'] ?? '',
                    $etab['y'] ?? ''
                ], ';');
            }
        } finally {
            fclose($handle);
        }
    }
    
    private function getFileNameForLevel($niveau)
    {
        $mapping = [
            'prescolaire' => 'prescolaire.csv',
            'primaire' => 'niveau_I.csv',
            'college' => 'niveau_II.csv',
            'lycee' => 'niveau_III.csv'
        ];
        
        return $mapping[$niveau] ?? 'niveau_I.csv';
    }
    
    // Méthodes pour l'administration (optionnelles)
    public function index()
    {
        // Lister les imports (pour l'administration)
        $imports = Storage::disk('public')->files('imports');
        
        return view('admin.imports.index', compact('imports'));
    }
    
    public function destroy($import)
    {
        // Supprimer un import (pour l'administration)
        if (Storage::disk('public')->exists("imports/{$import}")) {
            Storage::disk('public')->delete("imports/{$import}");
            
            return response()->json([
                'success' => true,
                'message' => 'Import supprimé avec succès'
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Import non trouvé'
        ], 404);
    }
}