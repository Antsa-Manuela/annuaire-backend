<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log; // Ajout pour les logs
use Illuminate\Validation\Rules;
use App\Models\SuperAdmin;
use App\Models\Admin;

class SuperAdminAuthController extends Controller
{
    /**
     * Connexion super admin (API)
     */
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'cin' => 'required|string',
                'password' => 'required',
            ]);

            $superAdmin = SuperAdmin::where('email', $request->email)
                                   ->where('cin', $request->cin)
                                   ->where('is_active', true)
                                   ->first();

            if ($superAdmin && Hash::check($request->password, $superAdmin->password)) {
                $token = $superAdmin->createToken('super-admin-token')->plainTextToken;
                return response()->json([
                    'user' => $superAdmin,
                    'token' => $token
                ]);
            }

            return response()->json(['message' => 'Identifiants incorrects'], 401);
        } catch (\Exception $e) {
            Log::error('SuperAdmin login error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'message' => 'Erreur interne du serveur',
                'error' => $e->getMessage() // À enlever en production
            ], 500);
        }
    }

    /**
     * Inscription super admin (API)
     */
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:super_admins',
                'cin' => 'required|string|max:255|unique:super_admins',
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            $superAdmin = SuperAdmin::create([
                'name' => $request->name,
                'email' => $request->email,
                'cin' => $request->cin,
                'password' => Hash::make($request->password),
                'is_active' => true,
            ]);

            $token = $superAdmin->createToken('super-admin-token')->plainTextToken;

            return response()->json([
                'user' => $superAdmin,
                'token' => $token
            ], 201);
        } catch (\Exception $e) {
            Log::error('SuperAdmin register error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'message' => 'Erreur interne du serveur',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Déconnexion super admin (API)
     */
    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return response()->json(['message' => 'Déconnexion réussie']);
        } catch (\Exception $e) {
            Log::error('SuperAdmin logout error: ' . $e->getMessage());
            return response()->json(['message' => 'Erreur lors de la déconnexion'], 500);
        }
    }

    /**
     * Récupérer l'utilisateur connecté
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * Lister les administrateurs avec filtres
     */
    public function getAdministrateurs(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $query = Admin::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('cin', 'like', "%{$search}%");
            });
        }

        if ($status === 'actif') {
            $query->where('is_active', true);
        } elseif ($status === 'inactif') {
            $query->where('is_active', false);
        }

        $administrateurs = $query->orderBy('created_at', 'desc')->get();

        return response()->json($administrateurs);
    }

    /**
     * Activer un administrateur
     */
    public function activerAdministrateur($id)
    {
        try {
            $admin = Admin::findOrFail($id);
            $admin->update(['is_active' => true]);
            return response()->json(['message' => 'Administrateur activé avec succès.']);
        } catch (\Exception $e) {
            Log::error('Activer admin error: ' . $e->getMessage());
            return response()->json(['message' => 'Erreur lors de l\'activation'], 500);
        }
    }

    /**
     * Désactiver un administrateur
     */
    public function desactiverAdministrateur($id)
    {
        try {
            $admin = Admin::findOrFail($id);
            $admin->update(['is_active' => false]);
            return response()->json(['message' => 'Administrateur désactivé avec succès.']);
        } catch (\Exception $e) {
            Log::error('Désactiver admin error: ' . $e->getMessage());
            return response()->json(['message' => 'Erreur lors de la désactivation'], 500);
        }
    }

    /**
     * Supprimer un administrateur
     */
    public function supprimerAdministrateur($id)
    {
        try {
            $admin = Admin::findOrFail($id);
            $admin->delete();
            return response()->json(['message' => 'Administrateur supprimé avec succès.']);
        } catch (\Exception $e) {
            Log::error('Supprimer admin error: ' . $e->getMessage());
            return response()->json(['message' => 'Erreur lors de la suppression'], 500);
        }
    }

    /**
     * Ajouter un administrateur (créé par super admin)
     */
    public function ajouterAdministrateur(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'cin' => 'required|string|max:255|unique:admins',
                'email' => 'required|string|email|max:255|unique:admins',
                'password' => 'required|min:8',
            ]);

            $admin = Admin::create([
                'name' => $request->name,
                'cin' => $request->cin,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'is_active' => true,
            ]);

            return response()->json([
                'message' => 'Administrateur créé avec succès.',
                'admin' => $admin
            ], 201);
        } catch (\Exception $e) {
            Log::error('Ajouter admin error: ' . $e->getMessage());
            return response()->json(['message' => 'Erreur lors de la création'], 500);
        }
    }
}