<?php
// backend/routes/api.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\ImportController;
use App\Models\User;

// 🔹 PUBLIC ROUTES

Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register']);

// 🔹 TEST : récupérer tous les utilisateurs
Route::get('/users', function () {
    return User::all();
});


// 🔹 PROTECTED ROUTES (nécessitent un token Sanctum)

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/dashboard/data', [DashboardController::class, 'getDashboardData']);

    Route::get('/admin/activities', [DashboardController::class, 'getAdminActivities']);

    Route::get('/excel/export/activities', [ExcelController::class, 'exportAdminActivities']);

    Route::post('/excel/import/data', [ExcelController::class, 'importNavigationData']);

});