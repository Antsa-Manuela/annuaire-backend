<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gestion des Administrateurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        *{
            font-size: 1vw;
        }
    </style>
</head>
<body class="mb-5">
    <!-- En-tête -->
    <div class="container-fluid py-3 px-4" style="background: linear-gradient(135deg, #3E6E4B 0%, #2d5139 100%); position: sticky; top: 0; z-index: 1030;">
        <div class="row align-items-center">
            <!-- Logo / Titre -->
            <div class="col-md-4 d-flex align-items-center">
                <div class="rounded-circle d-flex justify-content-center align-items-center me-3"
                     style="width: 10vw; min-width: 50px;">
                    <img src="{{ asset('data/i.vak/logo_stage_normal_png.png') }}" 
                         alt="Logo Vakinankaratra"
                         style="width: 8vw; min-width: 40px; object-fit: contain;">
                </div>
                <div>
                    <h6 class="h6 text-white mb-0">Gestionnaire des administrateurs</h6>
                    <small class="text-white-50">Région Vakinankaratra - Madagascar</small>
                </div>
            </div>

            <!-- Barre de recherche centrée -->
            <div class="col-md">
                <form id="searchForm" method="GET" action="{{ route('super-admin.administrateurs') }}">
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                    
                    <div class="input-group rounded-pill overflow-hidden border-0 shadow">
                        <span class="input-group-text border-0" 
                            style="background-color: #F6F4EC; padding-left: 1.5rem;">
                            <i class="fas fa-search" style="color: #3E6E4B;"></i>
                        </span>
                        
                        <input type="text" 
                            class="form-control border-0" 
                            name="search" 
                            placeholder="Rechercher par Nom, CIN, email ou date..." 
                            value="{{ request('search') }}" 
                            style="background-color: #F6F4EC; padding: 0.75rem; font-size: 0.9rem;">
                        
                        @if(request('search') || request('status'))
                        <a href="{{ route('super-admin.administrateurs', ['status' => request('status')]) }}" 
                        class="btn border-0 d-flex align-items-center" 
                        style="background-color: #9EC967; color: #FFFFFF; padding-left: 1rem; padding-right: 1rem;"
                        title="Effacer la recherche">
                            <i class="fas fa-times"></i>
                        </a>
                        @endif
                        
                        <button class="btn border-0 d-flex align-items-center" 
                                type="submit" 
                                style="background-color: #3E6E4B; color: #FFFFFF; padding-left: 1.5rem; padding-right: 1.5rem;">
                            <span>Rechercher</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Nom super admin et déconnexion -->
            <div class="col-md-4 text-end">
                <div class="d-flex align-items-center justify-content-end">
                    <div class="me-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-user-circle me-2" style="color: #FFFFFF; font-size: 1.5rem;"></i>
                            <span class="text-white fw-semibold" style="font-size: 0.9rem;">
                                {{ Auth::guard('super_admin')->user()->name }}
                            </span>
                        </div>
                    </div>
                    <form id="logout-form" action="{{ route('super-admin.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                    <button class="btn btn-outline-custom"
                            style="background-color: #9EC967; color: #fff;"
                            onclick="document.getElementById('logout-form').submit();"
                            onmouseover="this.style.backgroundColor='#2ECC71'; this.style.color='#fff';"
                            onmouseout="this.style.backgroundColor='#9EC967'; this.style.color='#fff';">
                        <i class="fas fa-power-off"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mt-4">
        <!-- Section unifiée : En-tête, statistiques et filtres -->
        <div class="card border-0 mb-4">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <!-- Statistique - Design carte amélioré -->
                    <div class="col-md-2">
                        <div class="card border-0 h-100">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center">
                                    <!-- Chiffre à gauche -->
                                    <div class="me-3">
                                        <h3 class="fw-bold text-success mb-0 fs-2">{{ $administrateurs->count() }}</h3>
                                    </div>
                                    
                                    <!-- Séparateur vertical -->
                                    <div class="vr me-3 text-muted"></div>
                                    
                                    <!-- Label et indicateur à droite -->
                                    <div class="d-flex flex-column">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-circle-fill me-1 small" 
                                            style="color: 
                                                @if(request('status') == 'actif') #28a745
                                                @elseif(request('status') == 'inactif') #ffc107
                                                @else #9EC967 @endif">
                                            </i>
                                            <small class="text-muted fw-medium">
                                                @if(request('status') == 'actif')
                                                    Comptes validés
                                                @elseif(request('status') == 'inactif')
                                                    En attente
                                                @else
                                                    Administrateurs
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filtres - Centré et amélioré -->
                    <div class="col-md-6">
                        <div class="text-center">
                            <div class="btn-group rounded-pill overflow-hidden" role="group" style="border: 1px solid #dee2e6;">
                                <a href="{{ route('super-admin.administrateurs', ['search' => request('search')]) }}" 
                                class="btn btn-light border-0 rounded-0 px-3 {{ !request('status') ? 'active text-white' : 'text-muted' }}" 
                                style="{{ !request('status') ? 'background: linear-gradient(135deg, #9EC967, #3E6E4B);' : '' }}">
                                    <i class="bi bi-grid-3x3-gap me-1"></i>Tous
                                </a>
                                <a href="{{ route('super-admin.administrateurs', ['status' => 'actif', 'search' => request('search')]) }}" 
                                class="btn btn-light border-0 rounded-0 px-3 {{ request('status') == 'actif' ? 'active text-white' : 'text-muted' }}" 
                                style="{{ request('status') == 'actif' ? 'background: linear-gradient(135deg, #9EC967, #3E6E4B);' : '' }}">
                                    <i class="bi bi-check-circle me-1"></i>Validés
                                </a>
                                <a href="{{ route('super-admin.administrateurs', ['status' => 'inactif', 'search' => request('search')]) }}" 
                                class="btn btn-light border-0 rounded-0 px-3 {{ request('status') == 'inactif' ? 'active text-white' : 'text-muted' }}" 
                                style="{{ request('status') == 'inactif' ? 'background: linear-gradient(135deg, #9EC967, #3E6E4B);' : '' }}">
                                    <i class="bi bi-clock me-1"></i>En attente
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Actions groupées - Plus compact -->
                    <div class="col-md-2">
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-success btn-sm" id="selectAllBtn"
                                    data-bs-toggle="tooltip" title="Sélectionner tous les administrateurs">
                                <i class="bi bi-check-all"></i>
                            </button>
                            <button class="btn btn-outline-danger btn-sm" id="deleteSelectedBtn"
                                    data-bs-toggle="tooltip" title="Supprimer les administrateurs sélectionnés">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Titre et bouton principal -->
                    <div class="col-md-2">
                        <button class="btn text-white shadow-sm align-self-start px-4 py-2" 
                            style="background: linear-gradient(135deg, #9EC967, #3E6E4B); border: none;"
                            data-bs-toggle="modal" data-bs-target="#addAdminModal">
                            <i class="bi bi-plus-circle me-2"></i>Nouvel administrateur
                        </button>
                    </div>
                    
                </div>
            </div>
        </div>

        <!-- Liste des administrateurs - Design moderne -->
        <div class="card border-0">
            <!-- En-tête amélioré avec indicateurs -->
            <div class="card-header bg-white border-bottom py-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                            <div class="d-flex align-items-center mt-1">
                                <span class="badge bg-light text-muted me-2">
                                    <i class="bi bi-funnel me-1"></i>
                                    @if(request('status') == 'actif')
                                        Validés
                                    @elseif(request('status') == 'inactif')
                                        En attente
                                    @else
                                        Tous les statuts
                                    @endif
                                </span>
                                <span class="text-muted small">• {{ $administrateurs->count() }} compte(s)</span>
                            </div>
                    </div>
                </div>
            </div>

            <!-- Tableau amélioré -->
            <div class="card-body p-0 my-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3" style="width: 50px;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="selectAll">
                                    </div>
                                </th>
                                <th class="py-3 text-success fw-semibold">Administrateur</th>
                                <th class="py-3 text-success fw-semibold">Contact</th>
                                <th class="py-3 text-success fw-semibold text-center">Statut</th>
                                <th class="py-3 text-success fw-semibold text-center">Dernière activité</th>
                                <th class="py-3 text-success fw-semibold text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($administrateurs as $admin)
                            <tr class="border-bottom hover-shadow">
                                <td class="ps-4">
                                    <div class="form-check">
                                        <input class="form-check-input admin-checkbox" type="checkbox" value="{{ $admin->id }}">
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="position-relative">
                                            <div class="rounded-circle me-3 d-flex align-items-center justify-content-center shadow-sm" 
                                                style="width: 42px; height: 42px; background: linear-gradient(135deg, #9EC967, #3E6E4B);">
                                                <i class="bi bi-person-fill text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-dark mb-1">
                                                {{ $admin->name ?? 'Admin ' . $admin->cin }}
                                            </div>
                                            <div class="text-muted small">
                                                CIN: {{ $admin->cin }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <div class="d-flex align-items-center mb-1">
                                            <span class="text-dark small">{{ $admin->email }}</span>
                                        </div>
                                        <div class="text-muted small">
                                            Inscrit le {{ $admin->created_at->format('d/m/Y') }}
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    @if($admin->is_active)
                                        <span class="badge bg-light-success text-success py-2 px-3 fw-medium">
                                            Actif
                                        </span>
                                    @else
                                        <span class="badge bg-light-warning text-warning py-2 px-3 fw-medium">
                                            En attente
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="text-muted small">
                                        {{ $admin->updated_at->diffForHumans() }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex gap-2 justify-content-end">
                                        @if(!$admin->is_active)
                                            <form method="POST" action="{{ route('super-admin.administrateurs.activer', $admin->id) }}" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm rounded-circle" 
                                                        style="border-color: #3E6E4B; color: #3E6E4B; width: 32px; height: 32px;"
                                                        data-bs-toggle="tooltip" title="Valider ce compte"
                                                        onclick="return confirm('Êtes-vous sûr de vouloir valider cet administrateur ?')">
                                                    <i class="bi bi-check-lg"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('super-admin.administrateurs.desactiver', $admin->id) }}" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm rounded-circle" 
                                                        style="border-color: #ffc107; color: #ffc107; width: 32px; height: 32px;"
                                                        data-bs-toggle="tooltip" title="Désactiver l'administrateur"
                                                        onclick="return confirm('Êtes-vous sûr de vouloir désactiver cet administrateur ?')">
                                                    <i class="bi bi-x-circle"></i>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <form method="POST" action="{{ route('super-admin.administrateurs.supprimer', $admin->id) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm rounded-circle" 
                                                    style="border-color: #dc3545; color: #dc3545; width: 32px; height: 32px;"
                                                    data-bs-toggle="tooltip" title="Renvoyer définitivement"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir renvoyer définitivement cet administrateur ?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            
                            @if($administrateurs->isEmpty())
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="py-4">
                                        <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" 
                                            style="width: 80px; height: 80px; background: linear-gradient(135deg, #f8f9fa, #e9ecef);">
                                            <i class="bi bi-people text-muted fs-2"></i>
                                        </div>
                                        <h5 class="text-muted mb-2">Aucun administrateur trouvé</h5>
                                        <p class="text-muted mb-4">
                                            @if(request('status') == 'actif')
                                                Aucun compte administrateur validé pour le moment.
                                            @elseif(request('status') == 'inactif')
                                                Aucune demande d'administration en attente.
                                            @else
                                                Votre liste d'administrateurs est vide.
                                            @endif
                                        </p>
                                        <button class="btn text-white px-4" style="background: linear-gradient(135deg, #9EC967, #3E6E4B);" 
                                                data-bs-toggle="modal" data-bs-target="#addAdminModal">
                                            <i class="bi bi-plus-circle me-2"></i>Créer le premier compte
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal pour ajouter un administrateur amélioré -->
    <div class="modal fade" id="addAdminModal" tabindex="-1" aria-labelledby="addAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header text-white" style="background: linear-gradient(135deg, #9EC967, #3E6E4B);">
                    <h5 class="modal-title" id="addAdminModalLabel">
                        <i class="bi bi-person-plus me-2"></i>Nouvel administrateur
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('super-admin.administrateurs.ajouter') }}">
                    @csrf
                    <div class="modal-body py-4">
                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold text-success">Nom complet</label>
                            <div class="input-group shadow-sm">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-person text-success"></i>
                                </span>
                                <input type="text" class="form-control border-start-0 ps-3" id="name" name="name" required 
                                    placeholder="Saisir le nom complet">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="cin" class="form-label fw-semibold text-success">Numéro CIN</label>
                            <div class="input-group shadow-sm">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-person-badge text-success"></i>
                                </span>
                                <input type="text" class="form-control border-start-0 ps-3" id="cin" name="cin" required placeholder="Saisir le numéro CIN">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold text-success">Adresse email</label>
                            <div class="input-group shadow-sm">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-envelope text-success"></i>
                                </span>
                                <input type="email" class="form-control border-start-0 ps-3" id="email" name="email" required placeholder="Saisir l'adresse email">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold text-success">Mot de passe</label>
                            <div class="input-group shadow-sm">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-lock text-success"></i>
                                </span>
                                <input type="password" class="form-control border-start-0 ps-3" id="password" name="password" required placeholder="Créer un mot de passe sécurisé">
                            </div>
                            <div class="form-text text-muted mt-2">
                                <i class="bi bi-info-circle me-1"></i>Le mot de passe doit contenir au moins 8 caractères
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary shadow-sm" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn text-white shadow-sm" style="background-color: #3E6E4B;">
                            <i class="bi bi-person-plus me-2"></i>Créer l'administrateur
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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

    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Activation des tooltips Bootstrap
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Gestion de la sélection multiple
        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.admin-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        document.getElementById('selectAllBtn').addEventListener('click', function() {
            document.getElementById('selectAll').click();
        });

        document.getElementById('deleteSelectedBtn').addEventListener('click', function() {
            const selectedIds = Array.from(document.querySelectorAll('.admin-checkbox:checked'))
                .map(checkbox => checkbox.value);
            
            if (selectedIds.length === 0) {
                alert('Veuillez sélectionner au moins un administrateur.');
                return;
            }

            if (confirm('Êtes-vous sûr de vouloir supprimer les administrateurs sélectionnés ? Cette action est irréversible.')) {
                // Implémentez ici la logique pour supprimer les administrateurs sélectionnés
                console.log('Administrateurs à supprimer:', selectedIds);
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const compactViewToggle = document.getElementById('compactView');
            const table = document.querySelector('table');
            
            compactViewToggle.addEventListener('change', function() {
                if (this.checked) {
                    // Activer la vue compacte
                    table.classList.add('table-sm');
                    document.querySelectorAll('tr').forEach(row => {
                        row.style.height = '40px';
                    });
                    // Cacher certaines colonnes si nécessaire
                    document.querySelectorAll('td, th').forEach(cell => {
                        cell.style.padding = '0.5rem';
                    });
                } else {
                    // Désactiver la vue compacte
                    table.classList.remove('table-sm');
                    document.querySelectorAll('tr').forEach(row => {
                        row.style.height = '';
                    });
                    document.querySelectorAll('td, th').forEach(cell => {
                        cell.style.padding = '';
                    });
                }
            });
        });
    </script>
</body>
</html>