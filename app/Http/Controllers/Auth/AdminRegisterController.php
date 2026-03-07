<?php
// backend/app/Http/Controllers/Auth/AdminRegisterController.php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminRegisterController extends Controller
{
    public function showRegistrationForm()
    {
        $hasActiveAdmin = Admin::where('is_active', true)->exists();
        
        return view('auth.admin-register', compact('hasActiveAdmin'));
    }

    public function dashboard()
    {
    return view('admin.dashboard'); // Utilisera le layout admin
    }

    public function register(Request $request)
    {
        if (Admin::where('is_active', true)->exists()) {
            return redirect()->back()
                ->with('error', 'Un administrateur actif existe déjà. Contactez-le pour toute modification.');
        }

        $validator = Validator::make($request->all(), [
            'cin' => 'required|string|unique:admins',
            'email' => 'required|email|unique:admins',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Admin::create([
            'cin' => $request->cin,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_active' => true,
        ]);

        return redirect('/admin/login')
            ->with('success', 'Compte administrateur créé avec succès. Vous pouvez maintenant vous connecter.');
    }
}
