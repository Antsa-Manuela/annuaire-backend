<?php
// app/Services/DataAnalysisService.php

namespace App\Services;

use App\Models\Etablissement;
use Illuminate\Support\Facades\DB;

class DataAnalysisService
{
    public function getStatsGlobales()
    {
        return [
            'total_etablissements' => Etablissement::count(),
            'total_eleves' => Etablissement::sum('nb_ENF'),
            'total_enseignants' => Etablissement::selectRaw('SUM(nb_Ens_foncts + nb_PA_NonFonct + nb_PA_Fonct) as total')->value('total'),
            'repartition_secteur' => Etablissement::groupBy('secteur')
                ->selectRaw('secteur, COUNT(*) as count')
                ->pluck('count', 'secteur'),
            'top_communes' => Etablissement::groupBy('commune')
                ->selectRaw('commune, COUNT(*) as count')
                ->orderBy('count', 'desc')
                ->limit(10)
                ->get()
        ];
    }

    public function getStatsParCisco()
    {
        return Etablissement::groupBy('cisco')
            ->selectRaw('
                cisco,
                COUNT(*) as nb_etablissements,
                SUM(nb_ENF) as total_eleves,
                AVG(nb_Ens_foncts + nb_PA_NonFonct + nb_PA_Fonct) as avg_enseignants,
                SUM(nb_ENF) / NULLIF(SUM(nb_Ens_foncts + nb_PA_NonFonct + nb_PA_Fonct), 0) as ratio_eleves_enseignant
            ')
            ->get();
    }

    public function getCarteDonnees()
    {
        return Etablissement::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->select([
                'nom_etab', 'secteur', 'commune', 'latitude', 'longitude',
                'nb_ENF', 'nb_Ens_foncts', 'nb_PA_NonFonct'
            ])
            ->get()
            ->map(function ($etab) {
                return [
                    'name' => $etab->nom_etab,
                    'secteur' => $etab->secteur,
                    'commune' => $etab->commune,
                    'lat' => $etab->latitude,
                    'lng' => $etab->longitude,
                    'eleves' => $etab->nb_ENF,
                    'enseignants' => $etab->nb_Ens_foncts + $etab->nb_PA_NonFonct,
                    'color' => $etab->secteur === 'Publique' ? '#3498db' : '#e74c3c'
                ];
            });
    }
}