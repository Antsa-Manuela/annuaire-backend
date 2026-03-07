<?php
// backend/app/Http/Controllers/Auth/AdminAuthController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminAuthController extends Controller
{
    /**
     * Afficher le formulaire de connexion admin
     */
    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    /**
     * Traiter la tentative de connexion admin
     */
    public function login(Request $request)
    {
        // Validation des données
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'L\'email est obligatoire.',
            'email.email' => 'Veuillez entrer une adresse email valide.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 6 caractères.',
        ]);

        // Rechercher l'admin par email
        $admin = Admin::where('email', $request->email)->first();

        // Vérifier les identifiants
       if (!$admin || !Hash::check($request->password, $admin->password)) {
    throw ValidationException::withMessages([
        'email' => 'Les identifiants administrateur sont incorrects.',
    ]);
}


        // Vérifier si le compte est actif
        if (!$admin->is_active) {
            throw ValidationException::withMessages([
                'email' => 'Votre compte administrateur est désactivé.',
            ]);
        }

        // Connecter l'admin avec la garde 'admin'
        Auth::guard('admin')->login($admin, $request->boolean('remember'));
        
        // Mettre à jour la dernière connexion
        $admin->update(['last_login_at' => now()]);
        
        $request->session()->regenerate();

        // Redirection vers le dashboard admin
        return redirect()->intended(route('admin.dashboard'))
            ->with('success', 'Connexion réussie ! Bienvenue ' . $admin->name);
    }

    /**
     * Déconnexion admin
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('success', 'Vous avez été déconnecté avec succès.');
    }

    /**
     * Tableau de bord admin
     */
    public function dashboard()
    {
        return view('admin.dashboard');
    }
}