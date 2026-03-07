<!-- backend/resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annuaire des Établissements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        *{
            font-size: 0.8rem;
        }
        .hero-section {
            background: linear-gradient(135deg, #3E6E4B 0%, #3E6E4B 100%);
            color: white;
            padding: 3vw;
            text-align: center;
        }
        .card {
            box-shadow: 0vw 0vw 1vw #3e6e4b28;
            border-radius: 1vw;
            height: 12vw;
        }
    </style>
</head>
<body class="bg-light">
    <!-- Hero Section -->
    <section class="hero-section bg-primary">
        <div class="container">
            <div class="row justify-content-center">

                    <!-- Section Logo -->
                    <div class="logo-section mb-4">
                        <img src="{{ asset('data/i.vak/logo_stage_normal_png.png') }}" alt="Logo Annuaire Pro" class="img-fluid" style="width: 10vw;">
                    </div>             

                <div class="col-lg-8">
                    <h1 class="display-5 fw-bold mb-4" style="color: #9EC967;">Gérez vos établissements efficacement</h1>
                    <p class="lead mb-5 fs-5">Solution complète de gestion et consultation de vos établissements en temps réel</p>
                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <a href="{{ route('login') }}" class="btn btn-lg px-4 py-2 fw-semibold" style="background-color: #9EC967; color: #fff; border-radius: 2vw" onmouseover="this.style.backgroundColor='#8ab854'" onmouseout="this.style.backgroundColor='#9EC967'">
                            Se connecter
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4 py-2 fw-semibold" style="border-radius: 2vw; color: #fff;" onmouseover="this.style.backgroundColor='rgba(255,255,255,0.1)'" onmouseout="this.style.backgroundColor='transparent'">
                            S'inscrire maintenant
                        </a>
                        <!-- Bouton Super Administrateur -->
                        <a href="{{ route('super-admin.login') }}" class="btn btn-warning btn-lg px-4 py-2 fw-semibold" style="border-radius: 2vw; color: #000;" onmouseover="this.style.backgroundColor='#e0a800'" onmouseout="this.style.backgroundColor='#ffc107'">
                            Super Administrateur
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card border-0">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="bi bi-speedometer2" style="font-size: 3rem; color: #3E6E4B;"></i>
                            </div>
                            <h5 class="card-title fw-bold" style="color: #3E6E4B;">Dashboard Complet</h5>
                            <p class="card-text text-muted">Visualisez vos données en temps réel avec des graphiques intuitifs</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="bi bi-file-earmark-spreadsheet" style="font-size: 3rem; color: #3E6E4B;"></i>
                            </div>
                            <h5 class="card-title fw-bold" style="color: #3E6E4B;">Import/Export Excel</h5>
                            <p class="card-text text-muted">Gérez vos données facilement via des fichiers Excel</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="bi bi-shield-lock" style="font-size: 3rem; color: #3E6E4B;"></i>
                            </div>
                            <h5 class="card-title fw-bold" style="color: #3E6E4B;">Sécurité Avancée</h5>
                            <p class="card-text text-muted">Authentification sécurisée et protection des données</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-2 fixed-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0" style="font-size: 0.8rem;">&copy; i.vak Annuaire des établissements scolaire de Vakinankaratra 2025. Tous droits réservés.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="text-white text-decoration-none me-3" style="font-size: 0.8rem;">Mentions légales</a>
                    <a href="#" class="text-white text-decoration-none" style="font-size: 0.8rem;">Confidentialité</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>