<?php
// app/Services/AnalyseEducativeService.php

namespace App\Services;

use App\Models\Etablissement;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AnalyseEducativeService
{
    public function analyserParSecteur(): Collection
    {
        return Etablissement::select(
            'SECTEUR',
            DB::raw('COUNT(*) as nb_etablissements'),
            DB::raw('SUM(nb_ENF) as total_eleves'),
            DB::raw('SUM(effectif_total_Personnel) as total_personnel'),
            DB::raw('SUM(nb_Ens_foncts) as total_enseignants_fonctionnaires'),
            DB::raw('SUM(nb_PA_NonFonct) as total_pa_non_fonct'),
            DB::raw('SUM(nb_PA_Fonct) as total_pa_fonct'),
            DB::raw('SUM(nb_Benevoles) as total_benevoles')
        )
        ->groupBy('SECTEUR')
        ->get()
        ->map(function ($item) {
            $item->secteur_label = $item->SECTEUR == 0 ? 'Public' : 'Privé';
            return $item;
        });
    }

    public function analyserParCisco(): Collection
    {
        return Etablissement::select(
            'CISCO',
            DB::raw('COUNT(*) as nb_etablissements'),
            DB::raw('SUM(nb_ENF) as total_eleves'),
            DB::raw('SUM(effectif_total_Personnel) as total_personnel'),
            DB::raw('AVG(effectif_total_Personnel) as moyenne_personnel')
        )
        ->groupBy('CISCO')
        ->orderBy('total_personnel', 'DESC')
        ->get();
    }

    public function analyserParCommune(): Collection
    {
        return Etablissement::select(
            'COMMUNE',
            DB::raw('COUNT(*) as nb_etablissements'),
            DB::raw('SUM(nb_ENF) as total_eleves'),
            DB::raw('SUM(effectif_total_Personnel) as total_personnel')
        )
        ->groupBy('COMMUNE')
        ->orderBy('nb_etablissements', 'DESC')
        ->get();
    }

    public function getTopEtablissements(int $limit = 10, string $critere = 'effectif_total_Personnel'): Collection
    {
        $colonnesAutorisees = ['effectif_total_Personnel', 'nb_ENF', 'nb_Ens_foncts'];
        
        if (!in_array($critere, $colonnesAutorisees)) {
            $critere = 'effectif_total_Personnel';
        }

        return Etablissement::orderBy($critere, 'DESC')
            ->limit($limit)
            ->get(['CODE_ETAB', 'NOM_ETAB', 'CISCO', 'COMMUNE', $critere, 'SECTEUR']);
    }

    public function getStatistiquesPersonnel(): array
    {
        $stats = Etablissement::select(
            DB::raw('SUM(nb_Ens_foncts) as total_enseignants_fonctionnaires'),
            DB::raw('SUM(nb_PA_NonFonct) + SUM(nb_PA_Fonct) as total_personnel_auxiliaire'),
            DB::raw('SUM(nb_Benevoles) as total_benevoles'),
            DB::raw('SUM(effectif_total_Personnel) as total_effectif'),
            DB::raw('SUM(nb_ENF) as total_eleves')
        )->first();

        $ratio = $stats->total_enseignants_fonctionnaires > 0 
            ? round($stats->total_eleves / $stats->total_enseignants_fonctionnaires, 2)
            : 0;

        return [
            'total_enseignants_fonctionnaires' => $stats->total_enseignants_fonctionnaires,
            'total_personnel_auxiliaire' => $stats->total_personnel_auxiliaire,
            'total_benevoles' => $stats->total_benevoles,
            'total_effectif' => $stats->total_effectif,
            'total_eleves' => $stats->total_eleves,
            'ratio_eleve_enseignant' => $ratio
        ];
    }

    public function getRepartitionGeographique(): Collection
    {
        return Etablissement::whereNotNull('X')
            ->whereNotNull('Y')
            ->where('X', '!=', 0)
            ->where('Y', '!=', 0)
            ->get(['NOM_ETAB', 'CISCO', 'COMMUNE', 'X', 'Y', 'effectif_total_Personnel', 'SECTEUR']);
    }
}