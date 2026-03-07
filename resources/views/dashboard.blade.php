<!DOCTYPE html>
<html lang="fr" style="scrollbar-width: thin; scrollbar-color: #9EC967 #F6F4EC;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tableau de bord d'éducation - Vakinankaratra</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
    <!-- Leaflet Routing Machine CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />

    <!-- Leaflet Locate Control CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet.locatecontrol/dist/L.Control.Locate.min.css" />
    
    <!-- Styles personnalisés -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    <style>
        /* Styles additionnels inline */
        *{
            scrollbar-width: thin;
            scrollbar-color: #9EC967 #F6F4EC;
            font-size: 14px; !important;
        }
        .btn-toolbar .btn {
            color: #F6F4EC;
            background-color: #3E6E4B;
            transition: all 0.3s ease;
        }
        
        .btn-toolbar .btn:hover {
            background-color: #8ab857;
            color: white;
            transform: translateY(-2px);
        }
        
        .dropdown-menu {
            border-radius: 10px;
            border: 1px solid #dee2e6;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .dropdown-item.active {
            background-color: #3E6E4B;
            color: white;
        }

        /* Animation pour les boutons */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .btn-toolbar .btn:hover i {
            animation: pulse 1s infinite;
        }
        
        /* Style pour le header */
        .header-gradient {
            background: linear-gradient(135deg, #3E6E4B 0%, #2d5139 100%);
        }
        
        /* Bouton d'effacement d'itinéraire */
        .btn-clear-route {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 1000;
            background: rgba(231, 76, 60, 0.9);
            color: white;
            border: none;
            border-radius: 5px;
            padding: 8px 15px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }
        
        .btn-clear-route:hover {
            background: rgba(231, 76, 60, 1);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        
        .btn-group .btn.active {
            color: white !important;
        }        
        /* Ajustement du tableau et graphiques */
        .chart-wrapper {
            position: relative;
            width: 100%;
            height: 100%;
        }

        #ciscoChart, #secteurChart {
            width: 100% !important;
            height: 100% !important;
            max-height: 180px;
        }

        .card.chart-card {
            height: 100%;
        }

        .card.chart-card .card-body {
            padding: 0.5rem;
        }

        /* Ajustement pour les légendes des graphiques */
        .chartjs-legend {
            font-size: 0.7rem !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .col-md-8, .col-md-4 {
                width: 100%;
                margin-bottom: 1rem;
            }
            
            #ciscoChart, #secteurChart {
                max-height: 150px;
            }
        }
        
        /* Styles spécifiques pour la version fusionnée */
        .level-selector .btn {
            background-color: #fff !important;
            color: #229954 !important;
        }
        
        .filter-container {
            background-color: #F6F4EC;
            padding: 10px;
            border-radius: 8px;
        }
        
        .table-header-custom {
            background-color: #3E6E4B !important;
            color: #FFFFFF !important;
        }
        
        .badge-custom {
            background-color: #9EC967 !important;
            color: #3E6E4B !important;
        }
        
        .btn-filter-custom {
            background-color: #229954 !important;
            color: #FFFFFF !important;
            border-color: #229954 !important;
        }
        
        .btn-clear-custom {
            background-color: #FFFFFF !important;
            color: #229954 !important;
            border-color: #229954 !important;
        }
        
        .table-custom th {
            color: #3E6E4B !important;
            border-bottom: 2px solid #9EC967 !important;
            font-size: 9px !important;
        }
        
        .table-custom tbody {
            font-size: 11px !important;
            background-color: #FFFFFF !important;
        }
    </style>
</head>
<body style="background-color: #f1f1f1ff;">
    <!-- En-tête -->
    <div class="container-fluid py-3 px-4 header-gradient fixed-top">
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
                    <h6 class="h6 text-white mb-0">Tableau de bord</h6>
                    <small class="text-white-50">Région Vakinankaratra - Madagascar</small>
                </div>
            </div>

            <!-- Boutons centraux -->
            <div class="col-md-4 text-center">
                <div class="btn-toolbar justify-content-center gap-2">
                    <!-- Import -->
                    <button type="button" class="btn" 
                            onclick="window.dashboard.showImportModal()"
                            data-bs-toggle="tooltip" data-bs-placement="bottom" 
                            title="Importer des données"
                            style="background-color: #3E6E4B; color: #FFFFFF;">
                        <i class="fas fa-file-import"></i>
                    </button>                    
                    <!-- Export -->
                    <div class="btn-group">
                        <button class="btn dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false"
                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Exporter les données">
                            <i class="fas fa-file-export"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#" onclick="window.dashboard.exportToExcel()">
                                <i class="fas fa-file-excel me-2"></i>Excel (.xlsx)
                            </a></li>
                            <li><a class="dropdown-item" href="#" onclick="window.dashboard.exportToCSV()">
                                <i class="fas fa-file-csv me-2"></i>CSV
                            </a></li>
                        </ul>
                    </div>
                    
                    <!-- Archive -->
                    <div class="btn-group">
                        <button type="button" class="btn dropdown-toggle"
                                data-bs-toggle="dropdown"
                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Archive scolaire">
                            <i class="fas fa-archive"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" id="archiveDropdown">
                            <li><a class="dropdown-item active" href="#">2024-2025 <span class="badge bg-primary ms-2">Actuel</span></a></li>
                            <li><a class="dropdown-item" href="#">2023-2024</a></li>
                            <li><a class="dropdown-item" href="#">2022-2023</a></li>
                        </ul>
                    </div>

                    <!-- Itinéraire -->
                    <button type="button" class="btn position-relative"
                            onclick="window.dashboard.showItineraireModal()"
                            data-bs-toggle="tooltip" data-bs-placement="bottom" title="Calculer un itinéraire">
                        <i class="fas fa-route"></i>
                    </button>
                    
                    <!-- Vider le cache -->
                    <button class="btn"
                            onclick="clearCache()"
                            data-bs-toggle="tooltip" data-bs-placement="bottom" title="Vider le cache">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>

            <!-- Profil + Déconnexion -->
            <div class="col-md-4 text-end">
                <div class="d-flex justify-content-end align-items-center gap-2">
                    <i class="fas fa-user-circle fa-lg text-white"></i>
                    <span class="text-white fw-semibold me-3">
                        @auth
                            {{ auth()->user()->name ?? 'Administrateur' }}
                        @else
                            Invité
                        @endauth
                    </span>
                    <button class="btn btn-outline-custom" style="background-color: #9EC967; color: #fff;" onclick="logout()"
                            onmouseover="this.style.backgroundColor='#2ECC71'; this.style.color='#fff';"
                            onmouseout="this.style.backgroundColor='#9EC967'; this.style.color='#fff';">
                        <i class="fas fa-power-off"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Conteneur principal -->
    <div class="dashboard-container container-fluid py-4" style="margin-top: 10rem;">
        <!-- Titre principal -->
        <div class="text-center mb-4">
            <h2 class="page-title mb-3">Système de Gestion des Établissements Scolaires</h2>
            <p class="page-subtitle mb-4" id="pageSubtitle">Visualisation des données des établissements Préscolaire</p>
        </div>

        <!-- Sélecteur de niveau -->
        <div class="level-selector mb-3">
            <div class="d-flex justify-content-center">
                <div class="btn-group btn-group-lg" role="group" aria-label="Sélecteur de niveau scolaire">
                    <!-- Préscolaire -->
                    <button type="button" class="level-btn btn border-start border-top border-bottom rounded-start-pill px-4 py-3 d-flex align-items-center active" 
                            data-level="prescolaire">
                        <i class="fas fa-baby me-3 fa-lg"></i>
                        <div class="text-start">
                            <div class="fw-bold">Préscolaire</div>
                        </div>
                    </button>
                    
                    <!-- Primaire -->
                    <button type="button" class="level-btn btn border-start border-top border-bottom px-4 py-3 d-flex align-items-center"
                            data-level="primaire">
                        <i class="fas fa-child me-3 fa-lg"></i>
                        <div class="text-start">
                            <div class="fw-bold">Primaire</div>
                        </div>
                    </button>
                    
                    <!-- Collège -->
                    <button type="button" class="level-btn btn border-start border-top border-bottom px-4 py-3 d-flex align-items-center" data-level="college">
                        <i class="fas fa-user-graduate me-3 fa-lg"></i>
                        <div class="text-start">
                            <div class="fw-bold">Collège</div>
                        </div>
                    </button>
                    
                    <!-- Lycée -->
                    <button type="button" class="level-btn btn border border-top border-bottom rounded-end-pill px-4 py-3 d-flex align-items-center"
                            data-level="lycee">
                        <i class="fas fa-graduation-cap me-3 fa-lg"></i>
                        <div class="text-start">
                            <div class="fw-bold">Lycée</div>
                        </div>
                    </button>
                </div>
            </div>
        </div>

        <!-- filtre et carte géolocalisation -->
        <div class="row m-5">
            <!-- Partie gauche : Filtres + Statistiques -->
            <div class="col-lg-4 bg-white p-3 rounded" style="align-self: center; align-content: center; align-items: center;">
                <!-- Filtres -->
                <div class="card border-0 mb-3" style="border-top: 4px solid #3E6E4B; border: 1px solid #e9ecef;">
                    <div class="card-body p-2" style="background-color: #FFFFFF;">
                        <!-- Filtres existants -->
                        <div class="row g-2 align-items-center mb-3">
                            <!-- Champ CISCO -->
                            <div class="col-md-5 col-12">
                                <select class="form-select" id="ciscoFilter" style="border-color: #3E6E4B; font-size: 0.7rem;">
                                    <option value="all">Toutes les CISCO</option>
                                    <option value="AMBATOLAMPY">AMBATOLAMPY</option>
                                    <option value="ANTANIFOTSY">ANTANIFOTSY</option>
                                    <option value="ANTSIRABE I">ANTSIRABE I</option>
                                    <option value="ANTSIRABE II">ANTSIRABE II</option>
                                    <option value="BETAFO">BETAFO</option>
                                    <option value="FARATSIHO">FARATSIHO</option>
                                    <option value="MANDOTO">MANDOTO</option>
                                </select>
                            </div>
                            <!-- Champ Secteur -->
                            <div class="col-md-5 col-12">
                                <select class="form-select" id="secteurFilter" style="border-color: #3E6E4B; font-size: 0.7rem;">
                                    <option value="all">Tous secteurs</option>
                                    <option value="Publique">Public</option>
                                    <option value="Privée">Privé</option>
                                </select>
                            </div>
                            <!-- Bouton Appliquer -->
                            <div class="col-md-2 col-12">
                                <button class="btn w-100 d-flex align-items-center justify-content-center" 
                                        onclick="window.dashboard.applyFilters()"
                                        style="background: linear-gradient(135deg, var(--success-color), #229954); color: #FFFFFF;">
                                    <i class="fas fa-filter" style="font-size: 0.6rem;"></i>
                                </button>
                            </div>
                            <!-- Bouton Effacer -->
                            <!-- <div class="col-md-2 col-12">
                                <button class="btn w-100 d-flex align-items-center justify-content-center" 
                                        onclick="window.dashboard.clearFilters()"
                                        style="background-color: #fff; color: #229954; border: 1px solid #229954;">
                                    <i class="fas fa-times" style="font-size: 0.6rem;"></i>
                                </button>
                            </div> -->
                        </div>
                        <!-- Barre de recherche (nouvelle section au-dessus) -->
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text" 
                                    style="background-color: #fff; border-color: #9EC967;">
                                    <i class="fas fa-search" style="color: #3E6E4B;"></i>
                                </span>
                                <input type="text" 
                                    class="form-control" 
                                    id="searchFilter"
                                    placeholder="Rechercher un établissement..."
                                    style="border-color: #9EC967;"
                                    onkeyup="window.dashboard.applySearch()">
                                <button class="btn" 
                                        onclick="window.dashboard.clearSearch()"
                                        style="background-color: #fff; border-color: #9EC967; color: #9EC967;">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="mt-2 small text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Recherche par nom d'établissement, commune ou CISCO
                            </div>
                        </div> 
                    </div>
                </div>
                <!-- Cartes de statistiques -->
                <div class="stats-cards">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-2 g-3" id="statsContainer">
                        <!-- Les statistiques seront chargées dynamiquement -->
                        <div class="col text-center py-4">
                            <div class="spinner-border" role="status" style="color: #3E6E4B;"></div>
                            <p class="mt-2 text-muted">Chargement des données Préscolaire...</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Partie droite : Carte géolocalisation -->
            <div class="col-lg-8">
                <div class="card border-0 h-100" style="border-top: 4px solid #9EC967; border: 1px solid #e9ecef;">
                    <div class="card-header py-2 d-flex justify-content-between align-items-center" style="background-color: #fff; border-bottom: 1px solid #dee2e6;">
                        <span style="color: #3E6E4B; font-size: 0.9rem;">
                            <i class="fas fa-map me-2"></i>
                            <span id="mapHeader" class="fw-bold">Carte des Établissements Préscolaire</span>
                        </span>
                        <div class="btn-group btn-group-sm">
                            <button class="btn px-2 py-1" onclick="window.dashboard.exportToCSV()" 
                                    style="background-color: #3E6E4B; color: white; border: 1px solid #3E6E4B; font-size: 0.75rem;">
                                <i class="fas fa-download"></i>
                            </button>
                            <button class="btn px-2 py-1" onclick="refreshData()"
                                    style="background-color: #FFFFFF; color: #3E6E4B; border: 1px solid #3E6E4B; font-size: 0.75rem;">
                                <i class="fas fa-sync"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0 position-relative" style="height: 400px;">
                        <div id="map" class="h-100"></div>
                        <!-- Bouton d'effacement d'itinéraire -->
                        <button id="clearRouteBtn" class="btn btn-sm position-absolute top-0 end-0 m-2" 
                                style="display: none; background-color: #FFFFFF; color: #3E6E4B; border: 1px solid #3E6E4B; font-size: 0.7rem; padding: 2px 6px;"
                                onclick="window.dashboard.clearItineraire()">
                            <i class="fas fa-times me-1"></i>Effacer
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau et Graphiques -->
        <div class="row m-5 g-3 align-items-stretch">
            <!-- Tableau des établissements -->
            <div class="col-md-8 col-lg-9">
                <div class="card border-0 h-100 overflow-hidden">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center" style="background-color: #fff; border-bottom: 2px solid #3E6E4B;">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0 fw-bold" style="color: #3E6E4B;">Établissements Préscolaire</h6>
                                <small class="text-muted">Liste complète des établissements</small>
                            </div>
                        </div>
                        <div class="rounded-pill px-3 py-1 fw-bold " style="color: #3E6E4B; background-color: #fafafaff;" id="etablissementCount">0</div>
                    </div>
                    <div class="card-body p-0" style="background-color: #fff;">
                        <div class="table-responsive" style="height: 500px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #9EC967 #F6F4EC;">
                            <table class="table table-hover align-middle mb-0">
                                <!-- <thead class="sticky-top">
                                    <tr>
                                        <th class="ps-3 py-3 border-bottom" style="color: #3E6E4B; background-color: #fff;">
                                            <i class="fas fa-school me-2"></i>Établissement
                                        </th>
                                        <th class="py-3 border-bottom" style="color: #3E6E4B; background-color: #fff;">
                                            <i class="fas fa-network-wired me-2"></i>CISCO
                                        </th>
                                        <th class="py-3 border-bottom" style="color: #3E6E4B; background-color: #fff;">
                                            <i class="fas fa-map-marker-alt me-2"></i>Secteur
                                        </th>
                                        <th class="py-3 border-bottom" style="color: #3E6E4B; background-color: #fff;">
                                            <i class="fas fa-users me-2"></i>Élèves
                                        </th>
                                        <th class="pe-3 py-3 border-bottom" style="color: #3E6E4B; background-color: #fff;">
                                            <i class="fas fa-cogs me-2"></i>Actions
                                        </th>
                                    </tr>
                                </thead> -->
                                <tbody id="etablissementTable">
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <div class="py-4">
                                                <div class="spinner-border me-2" role="status" style="color: #9EC967; width: 1rem; height: 1rem;"></div>
                                                <span class="fw-bold" style="color: #3E6E4B;">Chargement des établissements...</span>
                                            </div>
                                            <small class="text-muted">Veuillez patienter</small>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer py-2 text-center" style="background-color: #fff; border-top: 1px solid #dee2e6;">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            <span id="statsSummary">0 établissements chargés</span>
                        </small>
                    </div>
                </div>
            </div>

            <!-- Graphiques -->
            <div class="col-md-4 col-lg-3">
                <div class="row g-3 h-100">
                    <!-- Graphique CISCO -->
                    <div class="col-12">
                        <div class="card border-0 h-100">
                            <div class="card-header py-3 d-flex align-items-center" style="background-color: #fff;border-bottom: 2px solid #3E6E4B;">
                                <div>
                                    <h6 class="mb-0 fw-bold" style="font-size: 0.9rem; color: #3E6E4B;">Répartition CISCO</h6>
                                    <small class="text-muted">---</small>
                                </div>
                            </div>
                            <div class="card-body p-2 d-flex align-items-center justify-content-center" style="background-color: #fff;">
                                <div class="w-100 h-100 position-relative" style="min-height: 150px;">
                                    <canvas id="ciscoChart"></canvas>
                                    <div class="position-absolute top-50 start-50 translate-middle text-center">
                                        <div class="d-flex align-items-center">
                                            <div class="me-2">
                                                <div class="rounded-circle" style="width: 10px; height: 10px; background-color: #9EC967;"></div>
                                            </div>
                                            <div id="ciscoPercentage" class="fw-bold" style="color: #3E6E4B; font-size: 1rem;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer py-2 text-center" style="background-color: #fff;">
                                <small class="text-muted">
                                    <i class="fas fa-list-ol me-1"></i>
                                    <span id="ciscoStats">0 CISCO</span>
                                </small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Graphique Secteur -->
                    <div class="col-12">
                        <div class="card border-0 h-100">
                            <div class="card-header py-3 d-flex align-items-center" style="background-color: #fff;border-bottom: 2px solid #3E6E4B;">
                                <div>
                                    <h6 class="mb-0 fw-bold" style="font-size: 0.9rem; color: #3E6E4B;">Public | Privé</h6>
                                    <small class="text-muted">Répartition par secteur</small>
                                </div>
                            </div>
                            <div class="card-body p-2 d-flex align-items-center justify-content-center" style="background-color: #fff;">
                                <div class="w-100 h-100 position-relative" style="min-height: 150px;">
                                    <canvas id="secteurChart"></canvas>
                                    <div class="position-absolute top-50 start-50 translate-middle text-center">
                                        <div class="d-flex align-items-center" style="background-color: #fff;">
                                            <div class="me-2">
                                                <div class="rounded-circle" style="width: 10px; height: 10px;"></div>
                                            </div>
                                            <div id="secteurPercentage" class="fw-bold" style="color: #3E6E4B; font-size: 1rem;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer py-2 text-center" style="background-color: #fff;">
                                <small class="text-muted">
                                    <i class="fas fa-balance-scale me-1"></i>
                                    <span id="secteurStats">Public: 0 | Privé: 0</span>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Détails Établissement -->
    <div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
        
        <div class="modal-header bg-success text-white">
            <h5 class="modal-title" id="detailModalLabel">
            <i class="fas fa-school me-2"></i>Détails de l'établissement
            </h5>
            <div class="btn-group">
            <button type="button" class="btn btn-sm btn-light" onclick="window.print()">
                <i class="fas fa-print"></i>
            </button>
            </div>
        </div>
        
        <div class="modal-body" id="detailModalBody">
            <!-- Contenu dynamique -->
        </div>
        
        <div class="modal-footer d-flex justify-content-between">
            <small class="text-muted">
            <i class="fas fa-info-circle me-1"></i>
            Dernière mise à jour: <span id="lastUpdate"></span>
            </small>
            <div class="btn-group">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                Fermer
            </button>
            <!-- 🚀 Nouveau bouton itinéraire -->
            <button type="button" class="btn btn-success" id="itineraireFromHereBtn">
                <i class="fas fa-route me-1"></i>Itinéraire depuis ma position
            </button>
            </div>
        </div>
        
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

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <!-- Leaflet Routing Machine -->
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
    <script src="https://unpkg.com/leaflet.locatecontrol/dist/L.Control.Locate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
    
    <!-- Script principal -->
    <script src="{{ asset('js/dashboard.js') }}"></script>
    
    <!-- Initialisation -->
    <script>
        // Initialisation
        document.addEventListener('DOMContentLoaded', function() {
            // Initialiser les tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Initialiser le dashboard
            if (window.dashboard && typeof window.dashboard.init === 'function') {
                setTimeout(() => {
                    window.dashboard.init();
                }, 100);
            }
            
            // Exécuter après le chargement complet
            window.addEventListener('load', function() {
                console.log('✅ Page complètement chargée');
                
                // Vérifier que XLSX est disponible
                if (typeof XLSX === 'undefined') {
                    console.error('❌ XLSX n\'est pas chargé!');
                    alert('Erreur: La bibliothèque XLSX n\'est pas chargée. L\'export Excel ne fonctionnera pas.');
                } else {
                    console.log('✅ XLSX est correctement chargé');
                }
            });
        });
    </script>
</body>
</html>