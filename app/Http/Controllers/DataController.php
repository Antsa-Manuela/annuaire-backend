<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DataController extends Controller
{
    public function prescolaire(): StreamedResponse
    {
        return $this->serveCSV('prescolaire2.csv');
    }

    public function primaire(): StreamedResponse
    {
        return $this->serveCSV('niveau_I2.csv');
    }

    public function college(): StreamedResponse
    {
        return $this->serveCSV('niveau_II2.csv');
    }

    public function lycee(): StreamedResponse
    {
        return $this->serveCSV('niveau_III2.csv');
    }

    private function serveCSV(string $filename): StreamedResponse
    {
        $path = storage_path("app/public/data/{$filename}");
        
        if (!file_exists($path)) {
            // Créer un fichier CSV vide si le fichier n'existe pas
            $this->createEmptyCSV($path);
        }

        return response()->streamDownload(function () use ($path) {
            readfile($path);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    private function createEmptyCSV(string $path): void
    {
        $directory = dirname($path);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
        
        // En-têtes basiques pour un fichier CSV d'établissements
        $headers = [
            'id_presco', 'code_etab', 'secteur', 'cisco', 'commune', 'zap', 'fokontany', 
            'nom_etab', 'x', 'y', 'nb_ENF', 'nb_Ens_foncts', 'nb_PA_NonFonct', 
            'nb_PA_Fonct', 'nb_Bénevoles', 'effectif_total_Personnels'
        ];
        
        $csvContent = implode(';', $headers) . "\n";
        file_put_contents($path, $csvContent);
    }
}