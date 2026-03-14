<?php
// backend/routes/api.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\Api\SuperAdminAuthController; // 👈 Import du contrôleur API super admin
use App\Models\Admin;

// 🔹 ROUTES PUBLIQUES
Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register']);

// 🔹 TEST API (liste utilisateurs)
Route::get('/users', function () {
    return response()->json(Admin::all());
});

// 🔹 ROUTES SUPER ADMIN (API)
Route::prefix('super-admin')->group(function () {
    // Routes publiques pour super admin
    Route::post('/login', [SuperAdminAuthController::class, 'login']);
    Route::post('/register', [SuperAdminAuthController::class, 'register']);

    // Routes protégées par Sanctum
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [SuperAdminAuthController::class, 'logout']);
        Route::get('/user', [SuperAdminAuthController::class, 'user']);
        Route::get('/administrateurs', [SuperAdminAuthController::class, 'getAdministrateurs']);
        Route::put('/administrateurs/{id}/activer', [SuperAdminAuthController::class, 'activerAdministrateur']);
        Route::put('/administrateurs/{id}/desactiver', [SuperAdminAuthController::class, 'desactiverAdministrateur']);
        Route::delete('/administrateurs/{id}', [SuperAdminAuthController::class, 'supprimerAdministrateur']);
        Route::post('/administrateurs', [SuperAdminAuthController::class, 'ajouterAdministrateur']);
    });
});

// 🔹 ROUTES PROTÉGÉES POUR ADMINISTRATEURS STANDARDS (Sanctum)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard/data', [DashboardController::class, 'getDashboardData']);
    Route::get('/admin/activities', [DashboardController::class, 'getAdminActivities']);
    Route::get('/excel/export/activities', [ExcelController::class, 'exportAdminActivities']);
    Route::post('/excel/import/data', [ExcelController::class, 'importNavigationData']);
});