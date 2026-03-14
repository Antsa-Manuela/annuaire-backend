<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
    }

    /**
     * Inscription super admin (API)
     */
    public function register(Request $request)
    {
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
    }

    /**
     * Déconnexion super admin (API)
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Déconnexion réussie']);
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
        $admin = Admin::findOrFail($id);
        $admin->update(['is_active' => true]);
        return response()->json(['message' => 'Administrateur activé avec succès.']);
    }

    /**
     * Désactiver un administrateur
     */
    public function desactiverAdministrateur($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->update(['is_active' => false]);
        return response()->json(['message' => 'Administrateur désactivé avec succès.']);
    }

    /**
     * Supprimer un administrateur
     */
    public function supprimerAdministrateur($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();
        return response()->json(['message' => 'Administrateur supprimé avec succès.']);
    }

    /**
     * Ajouter un administrateur (créé par super admin)
     */
    public function ajouterAdministrateur(Request $request)
    {
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
    }
}