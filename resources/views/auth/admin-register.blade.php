<!DOCTYPE html>
<!-- resources/views/auth/admin-register.blade.php -->
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Super Administrateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        *{
            font-size: 0.8rem;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container-fluid vh-100">
        <div class="row h-100">
            <!-- Colonne de gauche - Formulaire -->
            <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center text-white" style="background: linear-gradient(135deg, #3E6E4B 50%, #9EC967 100%);">
                <div class="text-center p-5">
                    <!-- Section Logo -->
                    <div class="logo-section mb-4">
                        <img src="{{ asset('data/i.vak/super-admin-icon.png') }}" alt="Logo Annuaire Pro" class="img-fluid" style="width: 30vw;">
                    </div>
                </div>
            </div>
            <!-- Colonne de droite - Formulaire d'inscription -->
            <div class="col-md-6 d-flex align-items-center justify-content-center" style="background-color: #FFF;">
                <div class="w-100" style="max-width: 30vw; font-size: 15px">
                    <!-- En-tête -->
                    <div class="text-center mb-5">
                        <!-- Section Logo -->
                        <div class="logo-section mb-4">
                            <img src="{{ asset('data/i.vak/logo_stage_dark1.png') }}" alt="Logo Annuaire Pro" class="img-fluid" style="width: 10vw;">
                        </div>
                        <h4 class="fw-bold" style="color: #3E6E4B;">Nouveau Super Administrateur</h4>
                        <p class="text-muted">Création de compte super administrateur</p>
                    </div>

                    <!-- Messages d'alerte -->
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Formulaire -->
                    <form method="POST" action="{{ route('super-admin.register.submit') }}">
                        @csrf

                        <!-- Champ Nom complet -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold" style="color: #3E6E4B">Nom complet</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-person text-muted"></i>
                                </span>
                                <input type="text" 
                                       class="form-control border-start-0 px-4 py-2 @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       required 
                                       autofocus
                                       placeholder="Votre nom complet">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Champ Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold" style="color: #3E6E4B">Adresse mail</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-envelope text-muted"></i>
                                </span>
                                <input type="email" 
                                       class="form-control border-start-0 px-4 py-2 @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required
                                       placeholder="Saisir votre adresse email">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Champ CIN -->
                        <div class="mb-3">
                            <label for="cin" class="form-label fw-semibold" style="color: #3E6E4B">Numéro CIN</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-person-badge text-muted"></i>
                                </span>
                                <input type="text" 
                                       class="form-control border-start-0 px-4 py-2 @error('cin') is-invalid @enderror" 
                                       id="cin" 
                                       name="cin" 
                                       value="{{ old('cin') }}" 
                                       required
                                       placeholder="Votre CIN">
                                @error('cin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Champ Mot de passe -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold" style="color: #3E6E4B">Mot de passe</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-lock text-muted"></i>
                                </span>
                                <input type="password" 
                                       class="form-control border-start-0 px-4 py-2 @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       required
                                       placeholder="Saisir votre mot de passe">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Champ Confirmation mot de passe -->
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label fw-semibold" style="color: #3E6E4B">Confirmer le mot de passe</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-lock-fill text-muted"></i>
                                </span>
                                <input type="password" 
                                       class="form-control border-start-0 px-4 py-2" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       required
                                       placeholder="Confirmer votre mot de passe">
                            </div>
                        </div>

                        <!-- Bouton de création de compte -->
                        <button type="submit" class="btn btn-success w-100 px-4 py-2 mb-3 fw-semibold" style="background-color: #3E6E4B; border: none; color: #fff; border-radius: 2vw" onmouseover="this.style.backgroundColor='#8ab854'" onmouseout="this.style.backgroundColor='#3E6E4B'">
                            Créer le compte
                        </button>

                        <!-- Liens de navigation -->
                        <div class="text-center">
                            <p class="text-muted mb-2">
                                Déjà un compte ? 
                                <a href="{{ route('super-admin.login') }}" class="text-decoration-none text-success fw-semibold">
                                    Se connecter
                                </a>
                            </p>
                            <a href="{{ route('home') }}" class="text-decoration-none text-success fw-semibold">
                                ← Accueil
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>