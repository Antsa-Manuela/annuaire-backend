<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        // vérifier si un admin existe déjà
/*         if (Admin::where('is_active', true)->exists()) {
            return response()->json([
                'message' => 'Un administrateur actif existe déjà.'
            ], 403);
        } */

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'cin' => 'required|string|unique:admins',
            'email' => 'required|email|unique:admins',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $admin = Admin::create([
            'name' => $request->name,
            'cin' => $request->cin,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_active' => true
        ]);

        return response()->json([
            'message' => 'Administrateur créé avec succès',
            'admin' => $admin
        ]);
    }
}