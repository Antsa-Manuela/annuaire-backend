// resources/js/dashboard.js - VERSION COMPLÈTE OPTIMISÉE

// ==================== CONFIGURATION ====================
const niveauxData = {
    prescolaire: { nom: "Préscolaire", etablissements: [] },
    primaire: { nom: "Primaire", etablissements: [] },
    college: { nom: "Collège", etablissements: [] },
    lycee: { nom: "Lycée", etablissements: [] }
};

const csvFiles = window.dashboardConfig?.csvFiles || {
    prescolaire: '/data/niveau_I.csv',
    primaire: '/data/niveau_II.csv', 
    college: '/data/niveau_III.csv',
    lycee: '/data/niveau_III.csv'
};

console.log('📁 Configuration CSV chargée:', csvFiles);

// ==================== VARIABLES GLOBALES ====================
let currentLevel = 'primaire';
let currentChart, secteurChart, map;
let filteredData = [];
let currentFilters = { 
    cisco: 'all', 
    secteur: 'all', 
    typeEcole: 'all',
    effectif: 'all',
    recherche: '' 
};

// ==================== FONCTIONS DE CHARGEMENT ====================

async function loadCSV(filePath) {
    try {
        console.log(`🔄 Chargement: ${filePath}`);
        
        const response = await fetch(filePath);
        
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}`);
        }
        
        const csvText = await response.text();
        
        if (!csvText || csvText.trim().length === 0) {
            console.warn('⚠️ Fichier CSV vide');
            return getDemoData(filePath);
        }
        
        const parsedData = parseCSV(csvText);
        console.log(`📈 ${parsedData.length} enregistrements parsés`);
        
        return parsedData;
        
    } catch (error) {
        console.error(`❌ Erreur: ${error.message}`);
        return getDemoData(filePath);
    }
}

function parseCSV(csvText) {
    const lines = csvText.split('\n').filter(line => line.trim().length > 0);
    
    if (lines.length < 2) return [];

    // Détection du séparateur
    const separator = lines[0].includes(';') ? ';' : ',';
    const headers = lines[0].split(separator)
        .map(header => header.trim().toLowerCase()
            .replace(/"/g, '')
            .replace(/\s+/g, '_')
            .replace(/^_+|_+$/g, ''));

    const etablissements = [];
    
    for (let i = 1; i < lines.length; i++) {
        const line = lines[i].trim();
        if (!line) continue;

        // Parsing robuste avec gestion des guillemets
        let values = [];
        let current = '';
        let inQuotes = false;
        
        for (let char of line) {
            if (char === '"') {
                inQuotes = !inQuotes;
            } else if (char === separator && !inQuotes) {
                values.push(current.trim());
                current = '';
            } else {
                current += char;
            }
        }
        values.push(current.trim());
        
        // Nettoyage des valeurs
        values = values.map(v => v.replace(/^"|"$/g, ''));
        
        const etab = {};
        let hasValidData = false;

        headers.forEach((header, index) => {
            let value = values[index] || '';
            
            // Conversion numérique
            if (['x', 'y', 'nb_enf', 'nb_ens_foncts', 'effectif_total_personnels'].includes(header)) {
                value = value.replace(',', '.');
                value = Number(value) || 0;
            }
            
            // Mapping des colonnes
            switch(header) {
                case 'nom_etab':
                    etab.nom = value || `Établissement ${i}`;
                    if (value) hasValidData = true;
                    break;
                case 'cisco':
                    etab.cisco = value || 'INCONNU';
                    break;
                case 'commune':
                    etab.commune = value || 'INCONNU';
                    break;
                case 'secteur':
                    etab.secteur = value === '0' ? 'Publique' : 'Privée';
                    break;
                case 'nb_enf':
                    etab.eleves = value;
                    break;
                case 'nb_ens_foncts':
                    etab.personnel = value;
                    break;
                case 'x':
                    etab.x = value;
                    break;
                case 'y':
                    etab.y = value;
                    break;
                default:
                    etab[header] = value;
            }
        });

        // Détermination du type d'école pour le primaire

        if (currentLevel === 'primaire') {
            const nomUpper = etab.nom.toUpperCase();
            if (nomUpper.includes('EPP') || nomUpper.startsWith('EPP')) {
                etab.typeEcole = 'EPP';
            } else if (nomUpper.includes('COMMUNAUTAIRE')) {
                etab.typeEcole = 'COMMUNAUTAIRE';
            } else if (nomUpper.includes('CATHOLIQUE')) {
                etab.typeEcole = 'PRIVE_CATHOLIQUE';
            } else if (nomUpper.includes('PRIVE') || nomUpper.includes('PRIVEE')) {
                etab.typeEcole = 'PRIVE_AUTRE';
            } else {
                etab.typeEcole = 'EPP'; // Par défaut
            }
        }

        if (hasValidData) {
            etablissements.push(etab);
        }
    }

    return etablissements;
}

function getDemoData(filePath) {
    const fileName = filePath.split('/').pop();
    
    const demoData = {
        'niveau_II.csv': Array.from({length: 822}, (_, i) => ({
            id: i + 1,
            nom: `EPP TEST ${String(i+1).padStart(3, '0')}`,
            cisco: ['AMBATOLAMPY', 'ANTANIFOTSY', 'ANTSIRABE I', 'ANTSIRABE II', 'BETAFO', 'FARATSIHO', 'MANDOTO'][i % 7],
            commune: `Commune ${(i % 20) + 1}`,
            secteur: i % 4 === 0 ? 'Privée' : 'Publique',
            eleves: Math.floor(Math.random() * 200) + 50,
            personnel: Math.floor(Math.random() * 10) + 2,
            x: 47.4 + (Math.random() - 0.5) * 0.5,
            y: -19.3 + (Math.random() - 0.5) * 0.5,
            typeEcole: ['EPP', 'EPP', 'COMMUNAUTAIRE', 'PRIVE_CATHOLIQUE', 'PRIVE_AUTRE'][i % 5]
        }))
    };

    return demoData[fileName] || [];
}

async function loadAllData() {
    console.log('🚀 CHARGEMENT DES DONNÉES...');
    showLoading();

    try {
        for (const [niveau, filePath] of Object.entries(csvFiles)) {
            console.log(`📂 ${niveau}: ${filePath}`);
            niveauxData[niveau].etablissements = await loadCSV(filePath);
            console.log(`✅ ${niveau}: ${niveauxData[niveau].etablissements.length} établissements`);
        }

        console.log('🎉 DONNÉES CHARGÉES!');
        initializeLevel(currentLevel);
        
    } catch (error) {
        console.error('💥 ERREUR:', error);
        // Fallback sur données demo
        Object.keys(csvFiles).forEach(niveau => {
            const fileName = csvFiles[niveau].split('/').pop();
            niveauxData[niveau].etablissements = getDemoData(`/data/${fileName}`);
        });
        initializeLevel(currentLevel);
    }
}

// ==================== FONCTIONS D'AFFICHAGE ====================

function showLoading() {
    document.getElementById('statsContainer').innerHTML = `
        <div class="row">
            <div class="col-12 text-center py-5">
                <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;"></div>
                <p class="mt-3 text-muted">Chargement des données éducatives...</p>
            </div>
        </div>
    `;
}

function initializeLevel(level) {
    console.log(`🎯 Initialisation: ${level}`);
    
    if (!niveauxData[level]?.etablissements?.length) {
        showError(`Données non disponibles pour ${level}`);
        return;
    }
    
    const data = niveauxData[level];
    filteredData = [...data.etablissements];
    
    updateStats(data.etablissements);
    initializeMap(data.etablissements);
    populateTable(data.etablissements);
    initializeCharts(data.etablissements);
    
    document.getElementById('tableHeader').textContent = `Établissements ${data.nom}`;
    updateTableCount();
    
    console.log(`✅ ${level} initialisé: ${data.etablissements.length} établissements`);
}

function updateStats(etablissements) {
    const total = etablissements.length;
    const eleves = etablissements.reduce((sum, e) => sum + (e.eleves || 0), 0);
    const personnel = etablissements.reduce((sum, e) => sum + (e.personnel || 0), 0);
    
    // Statistiques primaire
    let statsHTML = '';
    
    if (currentLevel === 'primaire') {
        const eppCount = etablissements.filter(e => e.typeEcole === 'EPP').length;
        const communautaireCount = etablissements.filter(e => e.typeEcole === 'COMMUNAUTAIRE').length;
        const priveCathCount = etablissements.filter(e => e.typeEcole === 'PRIVE_CATHOLIQUE').length;
        const priveAutreCount = etablissements.filter(e => e.typeEcole === 'PRIVE_AUTRE').length;
        const ciscoCount = new Set(etablissements.map(e => e.cisco)).size;

        statsHTML = `
            <div class="row">
                <div class="col-xl-2 col-md-4">
                    <div class="stats-card" style="border-left-color: #4e73df;">
                        <div class="stats-value">${total}</div>
                        <div class="stats-label">ÉCOLES PRIMAIRES</div>
                        <div class="stats-detail">Total des établissements</div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4">
                    <div class="stats-card" style="border-left-color: #1cc88a;">
                        <div class="stats-value">${eleves.toLocaleString()}</div>
                        <div class="stats-label">ÉLÈVES</div>
                        <div class="stats-detail">Effectif total</div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4">
                    <div class="stats-card" style="border-left-color: #36b9cc;">
                        <div class="stats-value">${personnel.toLocaleString()}</div>
                        <div class="stats-label">ENSEIGNANTS</div>
                        <div class="stats-detail">Personnel éducatif</div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4">
                    <div class="stats-card" style="border-left-color: #4e73df;">
                        <div class="stats-value">${eppCount}</div>
                        <div class="stats-label">EPP</div>
                        <div class="stats-detail">Écoles publiques</div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4">
                    <div class="stats-card" style="border-left-color: #1cc88a;">
                        <div class="stats-value">${communautaireCount}</div>
                        <div class="stats-label">COMMUNAUTAIRES</div>
                        <div class="stats-detail">Écoles communautaires</div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4">
                    <div class="stats-card" style="border-left-color: #f6c23e;">
                        <div class="stats-value">${priveCathCount + priveAutreCount}</div>
                        <div class="stats-label">PRIVÉES</div>
                        <div class="stats-detail">Écoles privées</div>
                    </div>
                </div>
            </div>
        `;
    } else {
        const publicCount = etablissements.filter(e => e.secteur === 'Publique').length;
        const priveCount = etablissements.filter(e => e.secteur === 'Privée').length;
        const communesCount = new Set(etablissements.map(e => e.commune)).size;

        statsHTML = `
            <div class="row">
                <div class="col-xl-2 col-md-4">
                    <div class="stats-card">
                        <div class="stats-value">${total}</div>
                        <div class="stats-label">ÉTABLISSEMENTS</div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4">
                    <div class="stats-card">
                        <div class="stats-value">${eleves.toLocaleString()}</div>
                        <div class="stats-label">ÉLÈVES</div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4">
                    <div class="stats-card">
                        <div class="stats-value">${personnel.toLocaleString()}</div>
                        <div class="stats-label">PERSONNEL</div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4">
                    <div class="stats-card">
                        <div class="stats-value">${communesCount}</div>
                        <div class="stats-label">COMMUNES</div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4">
                    <div class="stats-card">
                        <div class="stats-value">${publicCount}</div>
                        <div class="stats-label">PUBLICS</div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4">
                    <div class="stats-card">
                        <div class="stats-value">${priveCount}</div>
                        <div class="stats-label">PRIVÉS</div>
                    </div>
                </div>
            </div>
        `;
    }
    
    document.getElementById('statsContainer').innerHTML = statsHTML;
}

function populateTable(etablissements) {
    const tableBody = document.getElementById('etablissementTable');
    
    if (!etablissements.length) {
        tableBody.innerHTML = `<tr><td colspan="4" class="text-center py-4 text-muted">Aucun établissement trouvé</td></tr>`;
        return;
    }
    
    let html = '';
    etablissements.slice(0, 50).forEach(etab => {
        let badgeClass, typeText;
        
        if (currentLevel === 'primaire') {
            switch(etab.typeEcole) {
                case 'EPP':
                    badgeClass = 'badge-epp';
                    typeText = 'EPP';
                    break;
                case 'COMMUNAUTAIRE':
                    badgeClass = 'badge-communautaire';
                    typeText = 'COMMUNAUTAIRE';
                    break;
                case 'PRIVE_CATHOLIQUE':
                    badgeClass = 'badge-prive-catholique';
                    typeText = 'PRIVÉ CATH';
                    break;
                case 'PRIVE_AUTRE':
                    badgeClass = 'badge-prive-autre';
                    typeText = 'PRIVÉ AUTRE';
                    break;
                default:
                    badgeClass = etab.secteur === 'Publique' ? 'badge-public' : 'badge-private';
                    typeText = etab.secteur === 'Publique' ? 'PUBLIC' : 'PRIVÉ';
            }
        } else {
            badgeClass = etab.secteur === 'Publique' ? 'badge-public' : 'badge-private';
            typeText = etab.secteur === 'Publique' ? 'PUBLIC' : 'PRIVÉ';
        }
        
        html += `
            <tr>
                <td>
                    <div class="fw-bold">${etab.nom}</div>
                    <small class="text-muted">${etab.commune}</small>
                </td>
                <td><span class="badge bg-secondary">${etab.cisco}</span></td>
                <td><span class="badge ${badgeClass}">${typeText}</span></td>
                <td class="text-end">
                    <strong>${etab.eleves || 0}</strong>
                    <div class="small text-muted">${etab.personnel || 0} pers.</div>
                </td>
            </tr>
        `;
    });
    
    tableBody.innerHTML = html;
    updateTableCount();
}

function updateTableCount() {
    const count = filteredData.length;
    const displayed = Math.min(count, 50);
    document.getElementById('tableCount').textContent = `${displayed}/${count}`;
}

// ==================== FONCTIONS CARTE ====================

function initializeMap(etablissements) {
    if (map) map.remove();

    map = L.map('map').setView([-19.38, 47.44], 10);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);

    refreshMapMarkers(etablissements);
    addMapFilters();
}

function refreshMapMarkers(etablissements) {
    // Nettoyer les marqueurs existants

    map.eachLayer(layer => {
        if (layer instanceof L.CircleMarker) map.removeLayer(layer);
    });
    
    let markersCount = 0;
    
    etablissements.forEach(etab => {
        if (!etab.x || !etab.y || etab.x === 0 || etab.y === 0) return;
        
        let color, typeText;
        
        if (currentLevel === 'primaire') {
            switch(etab.typeEcole) {
                case 'EPP':
                    color = '#4e73df';
                    typeText = 'EPP';
                    break;
                case 'COMMUNAUTAIRE':
                    color = '#1cc88a';
                    typeText = 'Communautaire';
                    break;
                case 'PRIVE_CATHOLIQUE':
                    color = '#36b9cc';
                    typeText = 'Privé Catholique';
                    break;
                case 'PRIVE_AUTRE':
                    color = '#f6c23e';
                    typeText = 'Privé Autre';
                    break;
                default:
                    color = etab.secteur === 'Publique' ? '#4e73df' : '#e74c3c';
                    typeText = etab.secteur === 'Publique' ? 'Public' : 'Privé';
            }
        } else {
            color = etab.secteur === 'Publique' ? '#4e73df' : '#e74c3c';
            typeText = etab.secteur === 'Publique' ? 'Public' : 'Privé';
        }
        
        const radius = Math.max(Math.log((etab.eleves || 0) + 1) * 2, 6);
        
        const marker = L.circleMarker([etab.y, etab.x], {
            color: color,
            fillColor: color,
            fillOpacity: 0.7,
            radius: radius
        }).addTo(map);
        
        marker.bindPopup(`
            <div class="map-popup">
                <h6><strong>${etab.nom}</strong></h6>
                <hr class="my-1">
                <p class="mb-1"><strong>Type:</strong> ${typeText}</p>
                <p class="mb-1"><strong>CISCO:</strong> ${etab.cisco}</p>
                <p class="mb-1"><strong>Commune:</strong> ${etab.commune}</p>
                <p class="mb-1"><strong>Élèves:</strong> ${etab.eleves || 0}</p>
                <p class="mb-0"><strong>Personnel:</strong> ${etab.personnel || 0}</p>
            </div>
        `);
        
        markersCount++;
    });
    
    console.log(`📍 ${markersCount} marqueurs affichés`);
}

function addMapFilters() {
    const FilterControl = L.Control.extend({
        onAdd: function(map) {
            const container = L.DomUtil.create('div', 'map-filters-container');
            container.innerHTML = `
                <div class="card map-filters-card">
                    <div class="card-body p-2">
                        <h6 class="card-title mb-2">
                            <i class="fas fa-filter me-1"></i>Filtres Carte
                        </h6>
                        
                        ${currentLevel === 'primaire' ? `
                        <div class="mb-2">
                            <label class="small fw-bold text-muted">Type d'école</label>
                            <select class="form-select form-select-sm" id="mapTypeEcoleFilter">
                                <option value="all">Tous types</option>
                                <option value="EPP">EPP</option>
                                <option value="COMMUNAUTAIRE">Communautaire</option>
                                <option value="PRIVE_CATHOLIQUE">Privé Catholique</option>
                                <option value="PRIVE_AUTRE">Privé Autre</option>
                            </select>
                        </div>
                        ` : ''}
                        
                        <div class="mb-2">
                            <label class="small fw-bold text-muted">CISCO</label>
                            <select class="form-select form-select-sm" id="mapCiscoFilter">
                                <option value="all">Toutes CISCO</option>
                                <option value="AMBATOLAMPY">AMBATOLAMPY</option>
                                <option value="ANTANIFOTSY">ANTANIFOTSY</option>
                                <option value="ANTSIRABE I">ANTSIRABE I</option>
                                <option value="ANTSIRABE II">ANTSIRABE II</option>
                                <option value="BETAFO">BETAFO</option>
                                <option value="FARATSIHO">FARATSIHO</option>
                                <option value="MANDOTO">MANDOTO</option>
                            </select>
                        </div>
                        
                        <div class="d-grid gap-1">
                            <button class="btn btn-primary btn-sm" onclick="applyMapFilters()">
                                <i class="fas fa-check me-1"></i>Appliquer
                            </button>
                            <button class="btn btn-outline-secondary btn-sm" onclick="resetMapFilters()">
                                <i class="fas fa-undo me-1"></i>Réinitialiser
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            L.DomEvent.disableClickPropagation(container);
            L.DomEvent.disableScrollPropagation(container);
            
            return container;
        }
    });

    new FilterControl({ position: 'topright' }).addTo(map);
}

function applyMapFilters() {
    const ciscoFilter = document.getElementById('mapCiscoFilter').value;
    const typeEcoleFilter = currentLevel === 'primaire' ? document.getElementById('mapTypeEcoleFilter').value : 'all';
    
    let filtered = [...niveauxData[currentLevel].etablissements];
    
    if (ciscoFilter !== 'all') {
        filtered = filtered.filter(e => e.cisco === ciscoFilter);
    }
    
    if (currentLevel === 'primaire' && typeEcoleFilter !== 'all') {
        filtered = filtered.filter(e => e.typeEcole === typeEcoleFilter);
    }
    
    filteredData = filtered;
    
    updateStats(filtered);
    populateTable(filtered);
    refreshMapMarkers(filtered);
    initializeCharts(filtered);
    
    console.log(`✅ Filtres appliqués: ${filtered.length} établissements`);
}

function resetMapFilters() {
    document.getElementById('mapCiscoFilter').value = 'all';
    if (currentLevel === 'primaire') {
        document.getElementById('mapTypeEcoleFilter').value = 'all';
    }
    applyMapFilters();
}

// ==================== FONCTIONS GRAPHIQUES ====================

function initializeCharts(etablissements) {
    // Données par CISCO
    const ciscoCounts = {
        'AMBATOLAMPY': 0, 'ANTANIFOTSY': 0, 'ANTSIRABE I': 0,
        'ANTSIRABE II': 0, 'BETAFO': 0, 'FARATSIHO': 0, 'MANDOTO': 0
    };

    etablissements.forEach(etab => {
        if (ciscoCounts.hasOwnProperty(etab.cisco)) {
            ciscoCounts[etab.cisco]++;
        }
    });

    // Graphique CISCO
    const ciscoCtx = document.getElementById('ciscoChart').getContext('2d');
    if (currentChart) currentChart.destroy();
    
    currentChart = new Chart(ciscoCtx, {
        type: 'doughnut',
        data: {
            labels: Object.keys(ciscoCounts),
            datasets: [{
                data: Object.values(ciscoCounts),
                backgroundColor: ['#3498db', '#2ecc71', '#e74c3c', '#f39c12', '#9b59b6', '#1abc9c', '#34495e'],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    // Graphique secteur/type
    let secteurData;
    
    if (currentLevel === 'primaire') {
        const eppCount = etablissements.filter(e => e.typeEcole === 'EPP').length;
        const communautaireCount = etablissements.filter(e => e.typeEcole === 'COMMUNAUTAIRE').length;
        const priveCathCount = etablissements.filter(e => e.typeEcole === 'PRIVE_CATHOLIQUE').length;
        const priveAutreCount = etablissements.filter(e => e.typeEcole === 'PRIVE_AUTRE').length;
        
        secteurData = {
            labels: ['EPP', 'Communautaire', 'Privé Catholique', 'Privé Autre'],
            datasets: [{
                data: [eppCount, communautaireCount, priveCathCount, priveAutreCount],
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e'],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        };
    } else {
        const publicCount = etablissements.filter(e => e.secteur === 'Publique').length;
        const priveCount = etablissements.filter(e => e.secteur === 'Privée').length;
        
        secteurData = {
            labels: ['Public', 'Privé'],
            datasets: [{
                data: [publicCount, priveCount],
                backgroundColor: ['#27ae60', '#e74c3c'],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        };
    }

    const secteurCtx = document.getElementById('secteurChart').getContext('2d');
    if (secteurChart) secteurChart.destroy();
    
    secteurChart = new Chart(secteurCtx, {
        type: 'doughnut',
        data: secteurData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
}

// ==================== FONCTIONS GLOBALES ====================

function switchLevel(level) {
    document.querySelectorAll('.level-btn').forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    
    currentLevel = level;
    currentFilters = { cisco: 'all', secteur: 'all', typeEcole: 'all', effectif: 'all', recherche: '' };
    
    document.getElementById('ciscoFilter').value = 'all';
    document.getElementById('secteurFilter').value = 'all';
    document.getElementById('typeEcoleFilter').value = 'all';
    
    initializeLevel(level);
}

function applyFilters() {
    const ciscoFilter = document.getElementById('ciscoFilter').value;
    const secteurFilter = document.getElementById('secteurFilter').value;
    const typeEcoleFilter = document.getElementById('typeEcoleFilter').value;
    
    currentFilters.cisco = ciscoFilter;
    currentFilters.secteur = secteurFilter;
    currentFilters.typeEcole = typeEcoleFilter;
    
    let filtered = [...niveauxData[currentLevel].etablissements];
    
    if (ciscoFilter !== 'all') {
        filtered = filtered.filter(e => e.cisco === ciscoFilter);
    }
    
    if (secteurFilter !== 'all') {
        filtered = filtered.filter(e => e.secteur === secteurFilter);
    }
    
    if (currentLevel === 'primaire' && typeEcoleFilter !== 'all') {
        filtered = filtered.filter(e => e.typeEcole === typeEcoleFilter);
    }
    
    filteredData = filtered;
    
    updateStats(filtered);
    populateTable(filtered);
    refreshMapMarkers(filtered);
    initializeCharts(filtered);
    
    console.log(`✅ Filtres appliqués: ${filtered.length} établissements`);
}

function resetFilters() {
    document.getElementById('ciscoFilter').value = 'all';
    document.getElementById('secteurFilter').value = 'all';
    document.getElementById('typeEcoleFilter').value = 'all';
    applyFilters();
}

function exportData() {
    if (!filteredData.length) {
        alert('❌ Aucune donnée à exporter');
        return;
    }
    
    const csv = convertToCSV(filteredData);
    downloadCSV(csv, `ecoles_primaire_${new Date().toISOString().split('T')[0]}.csv`);
    
    console.log(`📤 Export de ${filteredData.length} établissements`);
}

function convertToCSV(objArray) {
    const headers = ['Nom', 'CISCO', 'Commune', 'Type', 'Secteur', 'Élèves', 'Personnel', 'X', 'Y'];
    const csvRows = [
        headers.join(','),
        ...objArray.map(row => 
            [
                `"${row.nom || ''}"`,
                `"${row.cisco || ''}"`,
                `"${row.commune || ''}"`,
                `"${row.typeEcole || row.secteur || ''}"`,
                `"${row.secteur || ''}"`,
                row.eleves || 0,
                row.personnel || 0,
                row.x || 0,
                row.y || 0
            ].join(',')
        )
    ];
    return csvRows.join('\n');
}

function downloadCSV(csv, filename) {
    const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);
    link.setAttribute('href', url);
    link.setAttribute('download', filename);
    link.style.visibility = 'hidden';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

function refreshData() {
    console.log('🔄 Actualisation des données...');
    loadAllData();
}

function showError(message) {
    document.getElementById('statsContainer').innerHTML = `
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle me-2"></i>${message}
        </div>
    `;
}

// ==================== INITIALISATION ====================

document.addEventListener('DOMContentLoaded', function() {
    console.log('🏁 Dashboard initializing...');
    loadAllData();
});

// Export des fonctions globales
window.switchLevel = switchLevel;
window.applyFilters = applyFilters;
window.applyMapFilters = applyMapFilters;
window.resetMapFilters = resetMapFilters;
window.resetFilters = resetFilters;
window.exportData = exportData;
window.refreshData = refreshData;