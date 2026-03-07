<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $niveaux = ['prescolaire', 'niveau_I', 'niveau_II', 'niveau_III'];
        $totalEtablissements = 0;
        $totalEleves = 0;
        $totalPersonnel = 0;
        $totalEnseignantsFonctionnaires = 0;
        $totalAuxiliaires = 0;
        $totalBenevoles = 0;
        $topEtablissements = collect();
        $analyseSecteur = [];
        $ciscos = [];

        $filtreCISCO = $request->get('cisco');

        foreach ($niveaux as $niveau) {
            $file = "csv/{$niveau}.csv";
            if (!Storage::exists($file)) continue;

            $csv = Storage::get($file);
            $lines = array_filter(array_map('str_getcsv', explode("\n", $csv)), function ($line) {
                return count($line) > 1;
            });

            // ✅ Vérification ici : juste après avoir obtenu $lines
            if (empty($lines) || !isset($lines[0])) {
                \Log::warning("Fichier CSV vide ou corrompu : {$file}");
                continue;
            }

            $headers = array_map('trim', $lines[0]);

            foreach (array_slice($lines, 1) as $line) {
                if (count($line) !== count($headers)) continue;

                $row = array_combine($headers, $line);
                if (!$row) continue;

                $cisco = $row['CISCO'] ?? 'Inconnu';
                $ciscos[$cisco] = true;

                if ($filtreCISCO && $row['CISCO'] !== $filtreCISCO) continue;

                $totalEtablissements++;
                $totalEleves += (int) ($row['effectif_total_Eleves'] ?? 0);
                $totalPersonnel += (int) ($row['effectif_total_Personnel'] ?? 0);
                $totalEnseignantsFonctionnaires += (int) ($row['nb_enseignants_fonctionnaires'] ?? 0);
                $totalAuxiliaires += (int) ($row['nb_personnel_auxiliaire'] ?? 0);
                $totalBenevoles += (int) ($row['nb_benevoles'] ?? 0);

                if (!empty($row['NOM_ETAB']) && !empty($row['effectif_total_Personnel'])) {
                    $topEtablissements->push((object) [
                        'NOM_ETAB' => $row['NOM_ETAB'],
                        'CISCO' => $row['CISCO'] ?? '',
                        'effectif_total_Personnel' => (int) $row['effectif_total_Personnel'],
                    ]);
                }

                if (isset($row['SECTEUR'])) {
                    $secteur = $row['SECTEUR'] == 0 ? 'Public' : 'Privé';
                    $analyseSecteur[$secteur] = ($analyseSecteur[$secteur] ?? 0) + 1;
                }
            }
        }

        $statistiquesGlobales = [
            'total_etablissements' => $totalEtablissements,
            'total_eleves' => $totalEleves,
            'total_personnel' => $totalPersonnel,
        ];

        $statistiquesPersonnel = [
            'total_enseignants_fonctionnaires' => $totalEnseignantsFonctionnaires,
            'total_personnel_auxiliaire' => $totalAuxiliaires,
            'total_benevoles' => $totalBenevoles,
            'total_effectif' => $totalPersonnel,
            'ratio_eleve_enseignant' => $totalEnseignantsFonctionnaires > 0
                ? round($totalEleves / $totalEnseignantsFonctionnaires, 1)
                : 'N/A',
        ];

        $analyseSecteurFormatted = collect($analyseSecteur)->map(function ($count, $label) {
            return (object) [
                'secteur_label' => $label,
                'SECTEUR' => $label === 'Public' ? 0 : 1,
                'nb_etablissements' => $count,
            ];
        })->values();

        $topEtablissements = $topEtablissements->sortByDesc('effectif_total_Personnel')->take(5);
        $listeCiscos = array_keys($ciscos);

        return view('dashboard', compact(
            'statistiquesGlobales',
            'statistiquesPersonnel',
            'analyseSecteurFormatted',
            'topEtablissements',
            'listeCiscos',
            'filtreCISCO'
        ));
    }
}
