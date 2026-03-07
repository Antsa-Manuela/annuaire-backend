<?php
// routes/web_ancien.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminAuthController;
// use App\Http\Controllers\DashboardExportController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\ImportController;

// ============================================
// PAGE D'ACCUEIL
// ============================================
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ============================================
// ROUTES POUR LES FICHIERS STATIQUES (CSS, JS, CSV, LOGO)
// ============================================

// Route pour les fichiers CSS
Route::get('/css/{filename}', function ($filename) {
    $path = resource_path("css/{$filename}");
    
    if (!file_exists($path)) {
        $path = public_path("css/{$filename}");
        if (!file_exists($path)) {
            abort(404, "Fichier CSS non trouvé: {$filename}");
        }
    }
    
    return response()->file($path, [
        'Content-Type' => 'text/css; charset=utf-8'
    ]);
})->where('filename', '.*');

// Route pour les fichiers JS
Route::get('/js/{filename}', function ($filename) {
    $path = resource_path("js/{$filename}");
    
    if (!file_exists($path)) {
        $path = public_path("js/{$filename}");
        if (!file_exists($path)) {
            abort(404, "Fichier JS non trouvé: {$filename}");
        }
    }
    
    return response()->file($path, [
        'Content-Type' => 'application/javascript; charset=utf-8'
    ]);
})->where('filename', '.*');

// Route pour les fichiers CSV
Route::get('/data/{filename}', function ($filename) {
    $possiblePaths = [
        storage_path("app/public/data/csv/{$filename}"),
        storage_path("app/public/data/{$filename}"),
        public_path("storage/data/csv/{$filename}"),
        public_path("data/{$filename}"),
    ];
    
    foreach ($possiblePaths as $path) {
        if (file_exists($path)) {
            return response()->file($path, [
                'Content-Type' => 'text/csv; charset=utf-8',
                'Access-Control-Allow-Origin' => '*'
            ]);
        }
    }
    
    abort(404, "Fichier CSV non trouvé: {$filename}");
})->where('filename', '.*');

// Route pour le logo
Route::get('/data/ivak/{filename}', function ($filename) {
    $possiblePaths = [
        public_path("data/ivak/{$filename}"),
        storage_path("app/public/data/ivak/{$filename}"),
        public_path("storage/data/ivak/{$filename}"),
        base_path("public/data/ivak/{$filename}"),
    ];
    
    foreach ($possiblePaths as $path) {
        if (file_exists($path)) {
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $mimeTypes = [
                'png' => 'image/png',
                'jpg' => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'gif' => 'image/gif',
                'svg' => 'image/svg+xml'
            ];
            
            $contentType = $mimeTypes[$extension] ?? 'image/png';
            
            return response()->file($path, [
                'Content-Type' => $contentType
            ]);
        }
    }
    
    abort(404, "Logo non trouvé: {$filename}");
})->where('filename', '.*');

// ============================================
// ROUTE DE DIAGNOSTIC
// ============================================
Route::get('/diagnostic', function() {
    $files = [
        'CSS' => [
            'path_resources' => resource_path('css/dashboard.css'),
            'path_public' => public_path('css/dashboard.css'),
            'url' => url('/css/dashboard.css')
        ],
        'JS' => [
            'path_resources' => resource_path('js/dashboard.js'),
            'path_public' => public_path('js/dashboard.js'),
            'url' => url('/js/dashboard.js')
        ],
        'Logo' => [
            'path' => public_path('data/ivak/logo_stage_normal_.png'),
            'url' => url('/data/ivak/logo_stage_normal_.png')
        ],
        'CSV Prescolaire' => [
            'path' => storage_path('app/public/data/csv/prescolaire.csv'),
            'url' => url('/data/prescolaire.csv')
        ],
        'CSV Primaire' => [
            'path' => storage_path('app/public/data/csv/niveau_I.csv'),
            'url' => url('/data/niveau_I.csv')
        ],
        'CSV College' => [
            'path' => storage_path('app/public/data/csv/niveau_II.csv'),
            'url' => url('/data/niveau_II.csv')
        ],
        'CSV Lycee' => [
            'path' => storage_path('app/public/data/csv/niveau_III.csv'),
            'url' => url('/data/niveau_III.csv')
        ]
    ];

    $results = [];
    foreach ($files as $name => $fileInfo) {
        $exists = false;
        $actualPath = '';
        
        if (isset($fileInfo['path_resources'])) {
            $exists = file_exists($fileInfo['path_resources']);
            $actualPath = $fileInfo['path_resources'];
        } elseif (isset($fileInfo['path_public'])) {
            $exists = file_exists($fileInfo['path_public']);
            $actualPath = $fileInfo['path_public'];
        } else {
            $exists = file_exists($fileInfo['path']);
            $actualPath = $fileInfo['path'];
        }
        
        $results[$name] = [
            'exists' => $exists,
            'path' => $actualPath,
            'url' => $fileInfo['url'],
            'size' => $exists ? filesize($actualPath) : 0,
            'readable' => $exists ? is_readable($actualPath) : false
        ];
    }

    return response()->json($results);
});

// ============================================
// ROUTES D'AUTHENTIFICATION UTILISATEUR
// ============================================
Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest')
    ->name('login.submit');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// ============================================
// INSCRIPTION UTILISATEUR/ADMIN
// ============================================
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit'); // ← Doit pointer vers RegisterController

// ============================================
// ROUTES PROTÉGÉES UTILISATEUR
// ============================================
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Route::get('/dashboard/export', [DashboardExportController::class, 'export'])->name('dashboard.export');
    
    // Routes d'importation protégées
    Route::post('/import/csv', [ImportController::class, 'importCSV'])->name('import.csv');
    Route::get('/import/template/{niveau}', [ImportController::class, 'downloadTemplate'])->name('import.template');
});

// ============================================
// AUTHENTIFICATION ADMIN
// ============================================
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])
        ->middleware('guest')
        ->name('login');
    
    Route::post('/login', [AdminAuthController::class, 'login'])
        ->middleware('guest')
        ->name('login.submit');
    
    Route::post('/logout', [AdminAuthController::class, 'logout'])
        ->middleware('auth:admin') // Utilise le guard 'admin'
        ->name('logout');

    // Routes protégées admin - AJOUT du middleware 'admin.active'
    Route::middleware(['auth:admin', 'admin.active'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        //Route::get('/dashboard/export', [DashboardExportController::class, 'export'])->name('dashboard.export');
        Route::post('/import/csv', [ImportController::class, 'importCSV'])->name('import.csv');
        Route::get('/import/template/{niveau}', [ImportController::class, 'downloadTemplate'])->name('import.template');

        // Routes réservées aux super_admins
        Route::middleware(['super_admin'])->group(function () {
            Route::get('/register', [AdminAuthController::class, 'showRegisterForm'])->name('register');
            Route::post('/register', [AdminAuthController::class, 'register'])->name('register.submit');
            Route::get('/imports', [ImportController::class, 'index'])->name('imports.index');
            Route::delete('/imports/{import}', [ImportController::class, 'destroy'])->name('imports.destroy');
        });
    });
});

// ============================================
// ROUTES SUPER ADMINISTRATEUR (NOUVELLES ROUTES)
// ============================================
Route::prefix('super-admin')->name('super-admin.')->group(function () {

    // Routes publiques pour super admin
    Route::get('/login', [App\Http\Controllers\Auth\SuperAdminAuthController::class, 'showLoginForm'])
        ->middleware('guest')
        ->name('login');
    
    Route::post('/login', [App\Http\Controllers\Auth\SuperAdminAuthController::class, 'login'])
        ->middleware('guest')
        ->name('login.submit');
    
    Route::get('/register', [App\Http\Controllers\Auth\SuperAdminAuthController::class, 'showRegisterForm'])
        ->middleware('guest')
        ->name('register');
    
    Route::post('/register', [App\Http\Controllers\Auth\SuperAdminAuthController::class, 'register'])
        ->middleware('guest')
        ->name('register.submit');
    
    Route::post('/logout', [App\Http\Controllers\Auth\SuperAdminAuthController::class, 'logout'])
        ->middleware('auth:super_admin') // Utilise le guard 'super-admin'
        ->name('logout');
    

    
    // Routes protégées super admin
    Route::middleware(['auth:super_admin'])->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Auth\SuperAdminAuthController::class, 'dashboard'])->name('dashboard');
        Route::get('/administrateurs', [App\Http\Controllers\Auth\SuperAdminAuthController::class, 'gestionAdministrateurs'])->name('administrateurs');
        Route::post('/administrateurs/ajouter', [App\Http\Controllers\Auth\SuperAdminAuthController::class, 'ajouterAdministrateur'])->name('administrateurs.ajouter');
        
        // CORRECTION: Routes séparées pour activation/désactivation
        Route::patch('/administrateurs/{id}/activer', [App\Http\Controllers\Auth\SuperAdminAuthController::class, 'activerAdministrateur'])->name('administrateurs.activer');
        Route::patch('/administrateurs/{id}/desactiver', [App\Http\Controllers\Auth\SuperAdminAuthController::class, 'desactiverAdministrateur'])->name('administrateurs.desactiver');
        
        Route::delete('/administrateurs/{id}', [App\Http\Controllers\Auth\SuperAdminAuthController::class, 'supprimerAdministrateur'])->name('administrateurs.supprimer');
    });
});

// ============================================
// REDIRECTION ADMIN
// ============================================
Route::redirect('/admin', '/admin/dashboard');

// ============================================
// PAGE 404
// ============================================
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});