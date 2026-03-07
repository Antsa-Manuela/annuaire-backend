<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminAuthController extends Controller
{
    /**
     * Afficher le formulaire de connexion administrateur
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Traiter la connexion administrateur
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Utiliser le guard 'admin' spécifiquement
        if (Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Redirection vers le dashboard admin
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'Les identifiants administrateur sont incorrects.',
        ])->onlyInput('email');
    }

    /**
     * Déconnexion administrateur
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }

    /**
     * Afficher le formulaire d'inscription administrateur (super admin seulement)
     */
    public function showRegisterForm()
    {
        return view('admin.auth.register');
    }

    /**
     * Traiter l'inscription d'un nouvel administrateur
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:admin,super_admin',
        ]);

        // Créer l'administrateur
        Admin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);

        return redirect()->route('admin.login')->with('success', 'Administrateur créé avec succès. Vous pouvez maintenant vous connecter.');
    }
}