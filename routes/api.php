<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Admin;
use App\Models\SuperAdmin;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\Api\SuperAdminAuthController;

// 🔹 DIAGNOSTIC : Vérification de la base de données et des tables critiques
Route::get('/test-db', function () {
    try {
        DB::connection()->getPdo();
        return response()->json([
            'status' => 'connected',
            'database' => DB::connection()->getDatabaseName(),
            'super_admins_table_exists' => Schema::hasTable('super_admins'),
            'super_admins_count' => SuperAdmin::count(),
            'personal_access_tokens_table_exists' => Schema::hasTable('personal_access_tokens'),
            'migrations_table_exists' => Schema::hasTable('migrations'),
            'last_migrations' => DB::table('migrations')->orderBy('id', 'desc')->limit(5)->get(),
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
});

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