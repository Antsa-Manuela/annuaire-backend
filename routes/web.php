<?php
// backend/routes/web.php
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'API Annuaire fonctionne'
    ]);
});