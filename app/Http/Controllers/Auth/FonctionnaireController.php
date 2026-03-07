<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fonctionnaire;
use App\Models\HistoriquePersonnel;
use Illuminate\Http\Request;

class FonctionnaireController extends Controller
{
    public function index()
    {
        $fonctionnaires = Fonctionnaire::all();
        return view('admin.fonctionnaires.index', compact('fonctionnaires'));
    }

    public function create()
    {
        return view('admin.fonctionnaires.create');
    }

    public function showLoginForm()
    {
    return view('auth.admin-login'); // Cette vue n'utilise pas de layout
    }

    public function dashboard()
    {
    return view('admin.dashboard'); // Utilisera le layout admin
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cin' => 'required|unique:fonctionnaires',
            'nom_complet' => 'required|string|max:255',
            'poste' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'email' => 'required|email|unique:fonctionnaires',
            'etablissement' => 'required|string|max:255',
        ]);

        $fonctionnaire = Fonctionnaire::create($validated);

        HistoriquePersonnel::create([
            'fonctionnaire_id' => $fonctionnaire->id,
            'evenement' => 'Embauche',
            'details' => 'Nouveau fonctionnaire ajouté au système',
            'date_evenement' => now(),
        ]);

        return redirect()->route('admin.fonctionnaires.index')
            ->with('success', 'Fonctionnaire ajouté avec succès');
    }

    public function show(Fonctionnaire $fonctionnaire)
    {
        return view('admin.fonctionnaires.show', compact('fonctionnaire'));
    }

    public function edit(Fonctionnaire $fonctionnaire)
    {
        return view('admin.fonctionnaires.edit', compact('fonctionnaire'));
    }

    public function update(Request $request, Fonctionnaire $fonctionnaire)
    {
        $validated = $request->validate([
            'nom_complet' => 'required|string|max:255',
            'poste' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'email' => 'required|email|unique:fonctionnaires,email,' . $fonctionnaire->id,
            'etablissement' => 'required|string|max:255',
        ]);

        $fonctionnaire->update($validated);

        return redirect()->route('admin.fonctionnaires.index')
            ->with('success', 'Fonctionnaire modifié avec succès');
    }

    public function destroy(Fonctionnaire $fonctionnaire)
    {
        $fonctionnaire->delete();
        
        return redirect()->route('admin.fonctionnaires.index')
            ->with('success', 'Fonctionnaire supprimé avec succès');
    }

    public function historique(Fonctionnaire $fonctionnaire)
    {
        $historique = $fonctionnaire->historique()->orderBy('date_evenement', 'desc')->get();
        return view('admin.fonctionnaires.historique', compact('fonctionnaire', 'historique'));
    }
}