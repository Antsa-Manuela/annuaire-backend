<?php
// backend/app/Http/Controllers/Auth/LoginController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['nullable','email'],
            'cin' => ['nullable','string'],
            'password' => ['required','string'],
        ]);

        $admin = null;

        if ($request->filled('email')) {
            $admin = Admin::where('email', $request->email)->first();
        } elseif ($request->filled('cin')) {
            $admin = Admin::where('cin', $request->cin)->first();
        }

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return response()->json([
                'message' => 'Identifiants incorrects'
            ], 401);
        }

        $token = $admin->createToken('auth_token')->plainTextToken;

        return response()->json([
            'admin' => $admin,
            'token' => $token
        ]);
    }
}