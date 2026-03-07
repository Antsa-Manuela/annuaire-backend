<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\SuperAdmin;
use App\Models\Admin;
use Illuminate\Support\Facades\Log;

class SuperAdminAuthController extends Controller
{
    /**
     * Afficher le formulaire de connexion super admin
     */
    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    /**
     * Traiter la connexion super admin
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'cin' => 'required|string',
            'password' => 'required',
        ]);

        // Vérifier dans la table super_admins
        $superAdmin = SuperAdmin::where('email', $request->email)
                               ->where('cin', $request->cin)
                               ->where('is_active', true)
                               ->first();

        if ($superAdmin && Hash::check($request->password, $superAdmin->password)) {
            // Connecter le super admin
            Auth::guard('super_admin')->login($superAdmin);
            $request->session()->regenerate();
            
            return redirect()->intended(route('super-admin.administrateurs'));
        }

        return back()->withErrors([
            'email' => 'Les identifiants fournis sont incorrects.',
        ]);
    }

    /**
     * Afficher le formulaire d'inscription super admin
     */
    public function showRegisterForm()
    {
        return view('auth.admin-register');
    }

    /**
     * Traiter l'inscription super admin
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:super_admins',
            'cin' => 'required|string|max:255|unique:super_admins',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Créer le super admin dans la table super_admins
        $superAdmin = SuperAdmin::create([
            'name' => $request->name,
            'email' => $request->email,
            'cin' => $request->cin,
            'password' => Hash::make($request->password),
            'is_active' => true,
        ]);

        Auth::guard('super_admin')->login($superAdmin);

        return redirect(route('super-admin.administrateurs'));
    }

    /**
     * Déconnexion super admin
     */
    public function logout(Request $request)
    {
        Auth::guard('super_admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('super-admin/login');
    }

    /**
     * Tableau de bord super admin
     */
    public function dashboard()
    {
        return redirect()->route('super-admin.administrateurs');
    }

    /**
     * Gestion des administrateurs AVEC FILTRES
     */
    public function gestionAdministrateurs(Request $request)
    {
        // Récupérer les paramètres de recherche
        $search = $request->input('search');
        $status = $request->input('status');
        
        // Construire la requête avec les filtres
        $query = Admin::query();
        
        // Filtre par recherche (nom, email, CIN)
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('cin', 'like', "%{$search}%");
            });
        }
        
        // Filtre par statut
        if ($status === 'actif') {
            $query->where('is_active', true);
        } elseif ($status === 'inactif') {
            $query->where('is_active', false);
        }
        // Si pas de filtre de statut, on affiche tous
        
        // Ordonner par date de création (les plus récents d'abord)
        $query->orderBy('created_at', 'desc');
        
        // Récupérer les administrateurs
        $administrateurs = $query->get();
        
        return view('admin.gestion-administrateurs', compact('administrateurs', 'search', 'status'));
    }

    /**
     * Activer un administrateur (CORRIGÉ)
     */
    public function activerAdministrateur($id)
    {
        $admin = Admin::findOrFail($id);
        
        // Log pour débogage
        Log::info("Activation admin - Avant: ID {$id}, is_active: {$admin->is_active}");
        
        // FORCER l'activation à true
        $admin->update(['is_active' => true]);
        
        // Recharger l'admin depuis la base
        $admin->refresh();
        
        Log::info("Activation admin - Après: ID {$id}, is_active: {$admin->is_active}");

        return redirect()->route('super-admin.administrateurs')
                         ->with('success', 'Administrateur validé avec succès.');
    }

    /**
     * Désactiver un administrateur (NOUVELLE MÉTHODE)
     */
    public function desactiverAdministrateur($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->update(['is_active' => false]);

        return redirect()->route('super-admin.administrateurs')
                         ->with('success', 'Administrateur désactivé avec succès.');
    }

    /**
     * Supprimer un administrateur
     */
    public function supprimerAdministrateur($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();

        return redirect()->route('super-admin.administrateurs')
                         ->with('success', 'Administrateur renvoyé avec succès.');
    }

    /**
     * Ajouter un nouvel administrateur
     */
    public function ajouterAdministrateur(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'cin' => 'required|string|max:255|unique:admins',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|min:8',
        ]);

        // Créer l'admin avec la structure de votre table admins
        Admin::create([
            'name' => $request->name,
            'cin' => $request->cin,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_active' => true,
        ]);

        return redirect()->route('super-admin.administrateurs')
                        ->with('success', 'Administrateur créé avec succès.');
    }
}