<?php
// backend/app/Http/Controllers/Auth/RegisterController.php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    /**
     * Afficher le formulaire d'inscription utilisateur
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Enregistre un nouvel administrateur (avec validation par super admin)
     */
    public function register(Request $request)
    {
        // dd('POST OK');
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'cin' => ['required', 'string', 'max:255', 'unique:admins'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        try {
            // dd($request->all());
            DB::beginTransaction();

            // Création d'un administrateur avec statut inactif
            $admin = Admin::create([
                'name' => $request->name,   // 👈 AJOUTE ÇA
                'cin' => $request->cin,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'is_active' => false,
            ]);

            DB::commit();

            // Redirection vers la page de connexion ADMIN avec message
            return redirect()->route('admin.login') // ← CORRECTION: rediriger vers admin.login
                ->with('success', 'Votre compte administrateur a été créé avec succès. La validation se fera par le super administrateur.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de la création du compte: ' . $e->getMessage())
                ->withInput();
        }
    }
}