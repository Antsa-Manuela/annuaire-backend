<?php
// app/Http/Controllers/AnalyseEducativeController.php

namespace App\Http\Controllers;

use App\Services\AnalyseEducativeService;
use App\Models\Etablissement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnalyseEducativeController extends Controller
{
    protected AnalyseEducativeService $analyseService;

    public function __construct(AnalyseEducativeService $analyseService)
    {
        $this->analyseService = $analyseService;
    }

    public function dashboard(): View
    {
        $statistiquesGlobales = Etablissement::getStatistiquesGlobales();
        $analyseSecteur = $this->analyseService->analyserParSecteur();
        $analyseCisco = $this->analyseService->analyserParCisco();
        $statistiquesPersonnel = $this->analyseService->getStatistiquesPersonnel();
        $topEtablissements = $this->analyseService->getTopEtablissements(10);

        return view('analyse.dashboard', compact(
            'statistiquesGlobales',
            'analyseSecteur',
            'analyseCisco',
            'statistiquesPersonnel',
            'topEtablissements'
        ));
    }

    public function apiStatistiques(): JsonResponse
    {
        $data = [
            'statistiques_globales' => Etablissement::getStatistiquesGlobales(),
            'analyse_secteur' => $this->analyseService->analyserParSecteur(),
            'analyse_cisco' => $this->analyseService->analyserParCisco(),
            'statistiques_personnel' => $this->analyseService->getStatistiquesPersonnel(),
            'top_etablissements' => $this->analyseService->getTopEtablissements(10),
            'repartition_geographique' => $this->analyseService->getRepartitionGeographique()
        ];

        return response()->json($data);
    }

    public function rechercherEtablissements(Request $request): JsonResponse
    {
        $query = Etablissement::query();

        if ($request->has('nom') && $request->nom) {
            $query->where('NOM_ETAB', 'LIKE', '%' . $request->nom . '%');
        }

        if ($request->has('cisco') && $request->cisco) {
            $query->where('CISCO', $request->cisco);
        }

        if ($request->has('secteur') && $request->secteur !== '') {
            $query->where('SECTEUR', $request->secteur);
        }

        if ($request->has('commune') && $request->commune) {
            $query->where('COMMUNE', 'LIKE', '%' . $request->commune . '%');
        }

        $resultats = $query->orderBy('NOM_ETAB')->get();

        return response()->json($resultats);
    }

    public function exporterDonnees(Request $request)
    {
        // Implémentation pour l'export Excel
        // Utiliser Laravel Excel ou une solution similaire
        return response()->json(['message' => 'Fonction d\'export à implémenter']);
    }
}