<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Afficher le formulaire de connexion utilisateur
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Traiter la tentative de connexion utilisateur
     */
    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Rechercher l'utilisateur par email
        $user = Admin::where('email', $request->email)->first();


        // Vérifier les identifiants
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => __('Les identifiants sont incorrects.'),
            ]);
        }

        // Connecter l'utilisateur
        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        // Redirection vers le dashboard utilisateur
        return redirect()->intended(route('dashboard'));
    }

    /**
     * Déconnexion utilisateur
     */
    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}