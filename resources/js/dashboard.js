// resources/js/dashboard.js - VERSION FINALE COMPLÈTE
console.log('🚀 Dashboard JavaScript chargé !');

// Création de l'objet dashboard global
window.dashboard = (function() {
    // Configuration des colonnes par niveau
    const columnConfig = {
        prescolaire: {
            csvColumns: [
                'code_etab', 'secteur', 'cisco', 'commune', 'zap', 'fokontany', 
                'nom_etab', 'x', 'y', 'Nom_prenoms_DIR', 'Contact_DIR', 'adresse_Etab',
                'nb_ENF', 'nb_Ens_foncts', 'nb_PA_NonFonct', 'nb_PA_Fonct', 'nb_Bénevoles', 'effectif_total_Personnels',
                'LAPEN', 'MAPEN', 'BAC', 'BTS', 'M1', 'M2', 'INGENIEUR', 'DEA', 'DOCTORAT', 'Inf_Bacc',
                'nb_classe_petite_section', 'nb_classe_moyenne_section', 'nb_classe_grande_section',
                'nb_classe_12em', 'nb_classe_11em', 'nb_classe_10em', 'nb_classe_9em',
                'nb_classe_8em', 'nb_classe_7em', 'nb_classe_6em', 'nb_classe_5em',
                'nb_classe_4em', 'nb_classe_3em', 'nb_seconde', 'nb_1ere', 'nb_Tle',
                'nb_Pr_A', 'nb_Pr_C', 'nb_Pr_D', 'nb_Pr_L', 'nb_Pr_OSE', 'nb_Pr_S', 'nb_Pr_tot', 'nb_T_A',
                'nb_Pr_T_C', 'nb_T_D', 'nb_T_L', 'nb_T_S', 'nb_T_OSE', 'nb_T_tot',
                'taux-bacc-A1', 'taux-bacc-A2', 'taux-bacc-C', 'taux-bacc-D',
                'taux-bacc-L', 'taux-bacc-OSE', 'taux-bacc-S',
                'resultat_global',
                'Montant_caisse-ecole', 'rapport_utilisation_caisse_ecole'
            ],
            niveauLabel: 'Préscolaire',
            examen: null,
            csvFile: '/data/prescolaire.csv'
        },
        
        primaire: {
            csvColumns: [
                'code_etab', 'secteur', 'cisco', 'commune', 'zap', 'fokontany', 
                'nom_etab', 'x', 'y', 'Nom_prenoms_DIR', 'Contact_DIR', 'adresse_Etab',
                'nb_ENF', 'nb_Ens_foncts', 'nb_PA_NonFonct', 'nb_PA_Fonct', 'nb_Bénevoles', 'effectif_total_Personnels',
                'LAPEN', 'MAPEN', 'BAC', 'BTS', 'M1', 'M2', 'INGENIEUR', 'DEA', 'DOCTORAT', 'Inf_Bacc',
                'nb_classe_petite_section', 'nb_classe_moyenne_section', 'nb_classe_grande_section',
                'nb_classe_12em', 'nb_classe_11em', 'nb_classe_10em', 'nb_classe_9em',
                'nb_classe_8em', 'nb_classe_7em', 'nb_classe_6em', 'nb_classe_5em',
                'nb_classe_4em', 'nb_classe_3em', 'nb_seconde', 'nb_1ere', 'nb_Tle',
                'nb_Pr_A', 'nb_Pr_C', 'nb_Pr_D', 'nb_Pr_L', 'nb_Pr_OSE', 'nb_Pr_S', 'nb_Pr_tot', 'nb_T_A',
                'nb_Pr_T_C', 'nb_T_D', 'nb_T_L', 'nb_T_S', 'nb_T_OSE', 'nb_T_tot',
                'taux-bacc-A1', 'taux-bacc-A2', 'taux-bacc-C', 'taux-bacc-D',
                'taux-bacc-L', 'taux-bacc-OSE', 'taux-bacc-S',
                'taux_CEPE', 'taux_reussite_bepc',
                'resultat_global',
                'Montant_caisse-ecole', 'rapport_utilisation_caisse_ecole'
            ],
            niveauLabel: 'Primaire',
            examen: 'CEPE',
            csvFile: '/data/niveau_I.csv'
        },
        
        college: {
            csvColumns: [
                'code_etab', 'secteur', 'cisco', 'commune', 'zap', 'fokontany', 
                'nom_etab', 'x', 'y', 'Nom_prenoms_DIR', 'Contact_DIR', 'adresse_Etab',
                'nb_ENF', 'nb_Ens_foncts', 'nb_PA_NonFonct', 'nb_PA_Fonct', 'nb_Bénevoles', 'effectif_total_Personnels',
                'LAPEN', 'MAPEN', 'BAC', 'BTS', 'M1', 'M2', 'INGENIEUR', 'DEA', 'DOCTORAT', 'Inf_Bacc',
                'nb_classe_petite_section', 'nb_classe_moyenne_section', 'nb_classe_grande_section',
                'nb_classe_12em', 'nb_classe_11em', 'nb_classe_10em', 'nb_classe_9em',
                'nb_classe_8em', 'nb_classe_7em', 'nb_classe_6em', 'nb_classe_5em',
                'nb_classe_4em', 'nb_classe_3em', 'nb_seconde', 'nb_1ere', 'nb_Tle',
                'nb_Pr_A', 'nb_Pr_C', 'nb_Pr_D', 'nb_Pr_L', 'nb_Pr_OSE', 'nb_Pr_S', 'nb_Pr_tot', 'nb_T_A',
                'nb_Pr_T_C', 'nb_T_D', 'nb_T_L', 'nb_T_S', 'nb_T_OSE', 'nb_T_tot',
                'taux-bacc-A1', 'taux-bacc-A2', 'taux-bacc-C', 'taux-bacc-D',
                'taux-bacc-L', 'taux-bacc-OSE', 'taux-bacc-S',
                'taux_CEPE', 'taux_reussite_bepc',
                'resultat_global',
                'Montant_caisse-ecole', 'rapport_utilisation_caisse_ecole'
            ],
            niveauLabel: 'Collège',
            examen: 'BEPC',
            csvFile: '/data/niveau_II.csv'
        },
        
        lycee: {
            csvColumns: [
                'code_etab', 'secteur', 'cisco', 'commune', 'zap', 'fokontany', 
                'nom_etab', 'x', 'y', 'Nom_prenoms_DIR', 'Contact_DIR', 'adresse_Etab',
                'nb_ENF', 'nb_Ens_foncts', 'nb_PA_NonFonct', 'nb_PA_Fonct', 'nb_Bénevoles', 'effectif_total_Personnels',
                'LAPEN', 'MAPEN', 'BAC', 'BTS', 'M1', 'M2', 'INGENIEUR', 'DEA', 'DOCTORAT', 'Inf_Bacc',
                'nb_classe_petite_section', 'nb_classe_moyenne_section', 'nb_classe_grande_section',
                'nb_classe_12em', 'nb_classe_11em', 'nb_classe_10em', 'nb_classe_9em',
                'nb_classe_8em', 'nb_classe_7em', 'nb_classe_6em', 'nb_classe_5em',
                'nb_classe_4em', 'nb_classe_3em', 'nb_seconde', 'nb_1ere', 'nb_Tle',
                'nb_Pr_A', 'nb_Pr_C', 'nb_Pr_D', 'nb_Pr_L', 'nb_Pr_OSE', 'nb_Pr_S', 'nb_Pr_tot', 'nb_T_A',
                'nb_Pr_T_C', 'nb_T_D', 'nb_T_L', 'nb_T_S', 'nb_T_OSE', 'nb_T_tot',
                'taux-bacc-A1', 'taux-bacc-A2', 'taux-bacc-C', 'taux-bacc-D',
                'taux-bacc-L', 'taux-bacc-OSE', 'taux-bacc-S',
                'taux_CEPE', 'taux_reussite_bepc',
                'resultat_global',
                'Montant_caisse-ecole', 'rapport_utilisation_caisse_ecole'
            ],
            niveauLabel: 'Lycée',
            examen: 'BACC',
            csvFile: '/data/niveau_III.csv'
        }
    };

    // Variables privées
    let currentLevel = 'prescolaire';
    let niveauxData = {
        prescolaire: [],
        primaire: [],
        college: [],
        lycee: []
    };
    let currentChart, secteurChart, map;
    let filteredData = [];
    let mapMarkers = [];
    let markerLayer = null;
    let isInitialized = false;
    let routingControl = null;
    
    // Variables pour l'itinéraire
    let currentUserLocation = null;
    let selectedStartEtablissement = null;
    let selectedEndEtablissement = null;

    // ==================== FONCTIONS UTILITAIRES ====================

    function formatValue(value, format) {
        if (value === undefined || value === null || value === '' || value === '????' || value === 'NULL' || value === 'null') {
            return '<span class="text-muted fst-italic">Non disponible</span>';
        }
        
        if (value === '0' && format !== 'percentage') {
            return '0';
        }
        
        switch(format) {
            case 'currency':
                const numValue = parseInt(value) || 0;
                return `${numValue.toLocaleString('fr-MG')} Ar`;
            case 'percentage':
                const floatValue = parseFloat(value) || 0;
                return `${floatValue.toFixed(2)}%`;
            default:
                return String(value);
        }
    }

    function formatDetailValue(value, format) {
        if (value === undefined || value === null || value === '' || value === '????' || value === 'NULL' || value === 'null') {
            return 'Non disponible';
        }
        
        if (value === '0' && format !== 'percentage') {
            return '0';
        }
        
        switch(format) {
            case 'currency':
                const numValue = parseInt(value) || 0;
                return `${numValue.toLocaleString('fr-MG')} Ar`;
            case 'percentage':
                const floatValue = parseFloat(value) || 0;
                return `${floatValue.toFixed(2)}%`;
            case 'number':
                const num = parseInt(value) || 0;
                return num.toLocaleString('fr-MG');
            default:
                return String(value);
        }
    }

    function showNotification(message, type = 'info') {
        console.log(`📢 ${type}: ${message}`);
        
        const alertClass = type === 'success' ? 'alert-success' : 
                          type === 'error' ? 'alert-danger' : 
                          type === 'warning' ? 'alert-warning' : 'alert-info';
        
        const alertHTML = `
            <div class="alert ${alertClass} alert-dismissible fade show position-fixed top-0 end-0 m-3" 
                 role="alert" style="z-index: 9999; max-width: 300px;">
                <strong>${type === 'success' ? '✓' : type === 'error' ? '✗' : 'ℹ'}</strong> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        document.body.insertAdjacentHTML('beforeend', alertHTML);
        
        setTimeout(() => {
            const alert = document.querySelector('.alert:last-child');
            if (alert) alert.remove();
        }, 5000);
    }

    // ==================== FONCTION POUR DÉTERMINER LES CLASSES ====================

    function getClassesInfo(etablissement, level) {
        console.log('🔍 Analyse des classes pour:', etablissement.nom_etab, 'niveau:', level);
        
        const getValue = (fieldName) => {
            const value = etablissement[fieldName];
            console.log(`  ${fieldName}:`, value);
            
            if (value === undefined || value === null || value === '' || 
                value === '????' || value === 'NULL' || value === 'null' || value === ' ') {
                return 0;
            }
            
            // Convertir en nombre
            const numValue = parseInt(value);
            return isNaN(numValue) ? 0 : numValue;
        };

        let classes = [];

        // Ajouter une fonction de debug pour voir toutes les colonnes de classes
        const classFields = Object.keys(etablissement).filter(key => 
            key.includes('classe') || key.includes('nb_') || key.includes('section')
        );
        
        console.log('📋 Champs de classes disponibles:', classFields);
        console.log('📊 Valeurs:', classFields.map(field => `${field}: ${etablissement[field]}`));

        switch(level) {
            case 'prescolaire':
                console.log('🎯 Niveau Préscolaire');
                const ps = getValue('nb_classe_petite_section');
                const ms = getValue('nb_classe_moyenne_section');
                const gs = getValue('nb_classe_grande_section');
                
                console.log('📊 Classes préscolaires:', { ps, ms, gs });
                
                if (ps > 0) classes.push({ 
                    label: 'Petite Section', 
                    value: ps, 
                    field: 'nb_classe_petite_section',
                    niveau: 'Préscolaire'
                });
                if (ms > 0) classes.push({ 
                    label: 'Moyenne Section', 
                    value: ms, 
                    field: 'nb_classe_moyenne_section',
                    niveau: 'Préscolaire'
                });
                if (gs > 0) classes.push({ 
                    label: 'Grande Section', 
                    value: gs, 
                    field: 'nb_classe_grande_section',
                    niveau: 'Préscolaire'
                });
                break;

            case 'primaire':
                console.log('🎯 Niveau Primaire');
                // Classes de la 12ème à la 7ème
                const primaireClasses = [];
                for (let i = 12; i >= 7; i--) {
                    const val = getValue(`nb_classe_${i}em`);
                    if (val > 0) {
                        primaireClasses.push({ 
                            label: `${i}ème`, 
                            value: val,
                            field: `nb_classe_${i}em`,
                            niveau: 'Primaire'
                        });
                    }
                }
                console.log('📊 Classes primaires:', primaireClasses);
                classes = primaireClasses;
                break;

            case 'college':
                console.log('🎯 Niveau Collège');
                // Classes de la 6ème à la 3ème
                const collegeClasses = [];
                [6, 5, 4, 3].forEach(niv => {
                    const val = getValue(`nb_classe_${niv}em`);
                    if (val > 0) {
                        collegeClasses.push({ 
                            label: `${niv}ème`, 
                            value: val,
                            field: `nb_classe_${niv}em`,
                            niveau: 'Collège'
                        });
                    }
                });
                console.log('📊 Classes collège:', collegeClasses);
                classes = collegeClasses;
                break;

            case 'lycee':
                console.log('🎯 Niveau Lycée');
                const lyceeClasses = [];
                
                // Seconde générale
                const seconde = getValue('nb_seconde');
                if (seconde > 0) {
                    lyceeClasses.push({ 
                        label: 'Seconde', 
                        value: seconde,
                        field: 'nb_seconde',
                        niveau: 'Lycée',
                        type: 'Seconde'
                    });
                }

                // Classes de Première par série
                const seriesPremiere = ['A', 'C', 'D', 'L', 'OSE', 'S'];
                seriesPremiere.forEach(serie => {
                    const val = getValue(`nb_Pr_${serie}`);
                    if (val > 0) {
                        lyceeClasses.push({ 
                            label: `Première ${serie}`, 
                            value: val,
                            field: `nb_Pr_${serie}`,
                            niveau: 'Lycée',
                            type: 'Première'
                        });
                    }
                });

                // Total Premières
                const totalPremieres = getValue('nb_Pr_tot');
                if (totalPremieres > 0) {
                    lyceeClasses.push({ 
                        label: 'Total Premières', 
                        value: totalPremieres,
                        field: 'nb_Pr_tot',
                        niveau: 'Lycée',
                        type: 'Total'
                    });
                }

                // Classes de Terminale par série
                const seriesTerminale = ['A', 'C', 'D', 'L', 'S', 'OSE'];
                seriesTerminale.forEach(serie => {
                    const val = getValue(`nb_T_${serie}`);
                    if (val > 0) {
                        lyceeClasses.push({ 
                            label: `Terminale ${serie}`, 
                            value: val,
                            field: `nb_T_${serie}`,
                            niveau: 'Lycée',
                            type: 'Terminale'
                        });
                    }
                });

                // Total Terminales
                const totalTerminales = getValue('nb_T_tot');
                if (totalTerminales > 0) {
                    lyceeClasses.push({ 
                        label: 'Total Terminales', 
                        value: totalTerminales,
                        field: 'nb_T_tot',
                        niveau: 'Lycée',
                        type: 'Total'
                    });
                }
                
                console.log('📊 Classes lycée:', lyceeClasses);
                classes = lyceeClasses;
                break;
        }

        console.log('✅ Classes trouvées:', classes);
        return classes;
    }

    // ==================== IMPORT FICHIER EXCEL/CSV ====================

    async function handleFileImport(file, niveau) {
        try {
            showNotification('Importation en cours...', 'info');
            
            let data = [];
            const fileExtension = file.name.split('.').pop().toLowerCase();
            
            if (fileExtension === 'csv') {
                const text = await file.text();
                data = parseCSV(text, niveau);
            } else if (fileExtension === 'xlsx' || fileExtension === 'xls') {
                data = await parseExcel(file, niveau);
            } else {
                throw new Error('Format de fichier non supporté. Utilisez CSV ou Excel.');
            }
            
            if (data.length > 0) {
                niveauxData[niveau] = data;
                saveToLocalStorage(niveau, data);
                
                showNotification(`${data.length} établissements importés pour ${columnConfig[niveau].niveauLabel}`, 'success');
                
                if (niveau === currentLevel) {
                    initializeLevel(niveau);
                }
                
                return true;
            } else {
                showNotification('Aucune donnée valide trouvée dans le fichier', 'warning');
                return false;
            }
            
        } catch (error) {
            console.error('❌ Erreur import:', error);
            showNotification(`Erreur lors de l'import: ${error.message}`, 'error');
            return false;
        }
    }

    async function parseExcel(file, niveau) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                try {
                    const data = new Uint8Array(e.target.result);
                    const workbook = XLSX.read(data, { type: 'array' });
                    
                    const firstSheet = workbook.Sheets[workbook.SheetNames[0]];
                    const jsonData = XLSX.utils.sheet_to_json(firstSheet, { header: 1 });
                    
                    if (jsonData.length < 2) {
                        resolve([]);
                        return;
                    }
                    
                    const headers = jsonData[0];
                    const etablissements = [];
                    
                    for (let i = 1; i < jsonData.length; i++) {
                        const row = jsonData[i];
                        const etab = {};
                        
                        headers.forEach((header, index) => {
                            if (header && row[index] !== undefined) {
                                const cleanHeader = header.trim()
                                    .replace(/"/g, '')
                                    .replace(/\s+/g, '_')
                                    .replace(/^_+|_+$/g, '');
                                etab[cleanHeader] = row[index];
                            }
                        });
                        
                        if (etab.nom_etab || etab.code_etab) {
                            Object.keys(etab).forEach(key => {
                                if (etab[key] === null || etab[key] === undefined) {
                                    etab[key] = '';
                                }
                            });
                            
                            etablissements.push(etab);
                        }
                    }
                    
                    resolve(etablissements);
                    
                } catch (error) {
                    reject(error);
                }
            };
            
            reader.onerror = function() {
                reject(new Error('Erreur de lecture du fichier'));
            };
            
            reader.readAsArrayBuffer(file);
        });
    }

    // ==================== GESTION LOCALSTORAGE ====================

    function saveToLocalStorage(niveau, data) {
        try {
            const key = `dashboard_${niveau}_data`;
            const timestamp = new Date().toISOString();
            
            let dataToSave = data;
            const originalSize = JSON.stringify(data).length;
            
            console.log(`📏 Taille estimée pour ${niveau}: ${originalSize.toLocaleString()} caractères`);
            
            if (originalSize > 2_000_000) {
                console.warn(`⚠️ Dataset ${niveau} trop volumineux pour localStorage, compression...`);
                
                dataToSave = data.map(item => ({
                    code_etab: item.code_etab,
                    nom_etab: item.nom_etab,
                    secteur: item.secteur,
                    cisco: item.cisco,
                    commune: item.commune,
                    x: item.x,
                    y: item.y,
                    nb_ENF: item.nb_ENF,
                    effectif_total_Personnels: item.effectif_total_Personnels,
                    nb_Ens_foncts: item.nb_Ens_foncts,
                    taux_CEPE: item.taux_CEPE,
                    taux_reussite_bepc: item.taux_reussite_bepc,
                    resultat_global: item.resultat_global
                }));
            }
            
            const storageData = {
                data: dataToSave,
                timestamp: timestamp,
                count: data.length,
                source: 'csv_file',
                version: '1.0'
            };
            
            localStorage.setItem(key, JSON.stringify(storageData));
            console.log(`💾 Données ${niveau} sauvegardées dans localStorage (${data.length} établissements)`);
            
        } catch (error) {
            console.warn(`⚠️ Erreur sauvegarde localStorage ${niveau}:`, error.message);
            
            if (error.message.includes('quota') || error.name === 'QuotaExceededError') {
                console.log('🗑️ Quota localStorage dépassé, nettoyage...');
                
                clearOldLocalStorageData();
                
                try {
                    const minimalData = data.slice(0, 1000).map(item => ({
                        code_etab: item.code_etab,
                        nom_etab: item.nom_etab,
                        secteur: item.secteur,
                        cisco: item.cisco,
                        commune: item.commune
                    }));
                    
                    const storageData = {
                        data: minimalData,
                        timestamp: new Date().toISOString(),
                        count: data.length,
                        source: 'csv_file_minimal',
                        version: '1.0'
                    };
                    
                    localStorage.setItem(`dashboard_${niveau}_data`, JSON.stringify(storageData));
                    console.log(`💾 Données minimales ${niveau} sauvegardées (${minimalData.length} établissements)`);
                    
                } catch (e) {
                    console.error('❌ Échec sauvegarde même avec données minimales:', e);
                }
            }
        }
    }
    
    function clearOldLocalStorageData() {
        const keys = Object.keys(localStorage);
        let count = 0;
        const oneWeekAgo = Date.now() - (7 * 24 * 60 * 60 * 1000);
        
        keys.forEach(key => {
            if (key.startsWith('dashboard_')) {
                try {
                    const item = localStorage.getItem(key);
                    if (item) {
                        const data = JSON.parse(item);
                        const itemDate = new Date(data.timestamp).getTime();
                        
                        if (itemDate < oneWeekAgo) {
                            localStorage.removeItem(key);
                            count++;
                        }
                    }
                } catch (e) {
                    localStorage.removeItem(key);
                    count++;
                }
            }
        });
        
        if (count > 0) {
            console.log(`🗑️ ${count} anciennes données supprimées du localStorage`);
        }
    }
    
    function loadFromLocalStorage(niveau) {
        try {
            const key = `dashboard_${niveau}_data`;
            const stored = localStorage.getItem(key);
            
            if (stored) {
                const parsed = JSON.parse(stored);
                
                const dataDate = new Date(parsed.timestamp).getTime();
                const oneWeekAgo = Date.now() - (7 * 24 * 60 * 60 * 1000);
                
                if (dataDate > oneWeekAgo) {
                    console.log(`📂 Données ${niveau} récupérées de localStorage (${parsed.data.length} établissements)`);
                    return parsed.data;
                } else {
                    console.log(`🗑️ Données ${niveau} trop anciennes, suppression...`);
                    localStorage.removeItem(key);
                }
            }
            
        } catch (error) {
            console.warn(`⚠️ Erreur lecture ${niveau} depuis localStorage:`, error.message);
            localStorage.removeItem(`dashboard_${niveau}_data`);
        }
        
        return null;
    }

    function clearLocalStorage() {
        const keys = Object.keys(localStorage);
        let count = 0;
        
        keys.forEach(key => {
            if (key.startsWith('dashboard_')) {
                localStorage.removeItem(key);
                count++;
            }
        });
        
        console.log(`🗑️ ${count} jeux de données supprimés du localStorage`);
        showNotification(`${count} jeux de données supprimés du cache`, 'success');
        return count;
    }

    // ==================== PARSING CSV ====================

    function parseCSV(csvText, niveau) {
        console.log(`📝 Parsing CSV pour ${niveau}...`);
        
        const lines = csvText.split('\n')
            .map(line => line.trim())
            .filter(line => line.length > 0);

        if (lines.length < 2) {
            console.warn(`⚠️ Fichier CSV vide pour ${niveau}`);
            return [];
        }

        const firstLine = lines[0];
        let separator = ';';
        if (firstLine.includes(',') && !firstLine.includes(';')) {
            separator = ',';
        } else if (!firstLine.includes(';') && !firstLine.includes(',')) {
            separator = '\t';
        }

        console.log(`🔍 Séparateur détecté: "${separator}"`);

        const headers = firstLine.split(separator)
            .map(header => header.trim()
                .replace(/"/g, '')
                .replace(/\s+/g, '_')
                .replace(/^_+|_+$/g, ''));

        const etablissements = [];
        const codesUniques = new Set();
        let lignesIgnored = 0;

        for (let i = 1; i < lines.length; i++) {
            const line = lines[i];
            if (!line.trim()) continue;

            const values = parseCSVLine(line, separator);
            
            if (values.length !== headers.length) {
                console.warn(`⚠️ Ligne ${i+1}: nombre de colonnes incorrect (${values.length} au lieu de ${headers.length})`);
                lignesIgnored++;
                continue;
            }

            const etab = {};

            headers.forEach((header, index) => {
                let value = values[index] || '';
                value = value.trim();
                
                if (value === '????' || value === 'null' || value === 'NULL' || value === 'undefined') {
                    value = '';
                }

                const numericFields = [
                    'x', 'y', 'nb_ENF', 'nb_Ens_foncts', 'effectif_total_Personnels', 
                    'nb_PA_NonFonct', 'nb_PA_Fonct', 'nb_Bénevoles', 'LAPEN', 'MAPEN', 
                    'BAC', 'BTS', 'M1', 'M2', 'INGENIEUR', 'DEA', 'DOCTORAT', 'Inf_Bacc',
                    'nb_classe_petite_section', 'nb_classe_moyenne_section', 'nb_classe_grande_section',
                    'nb_classe_12em', 'nb_classe_11em', 'nb_classe_10em', 'nb_classe_9em',
                    'nb_classe_8em', 'nb_classe_7em', 'nb_classe_6em', 'nb_classe_5em',
                    'nb_classe_4em', 'nb_classe_3em', 'nb_seconde', 'nb_1ere', 'nb_Tle',
                    'nb_Pr_A', 'nb_Pr_C', 'nb_Pr_D', 'nb_Pr_L', 'nb_Pr_OSE', 'nb_Pr_S', 'nb_Pr_tot', 'nb_T_A',
                    'nb_Pr_T_C', 'nb_T_D', 'nb_T_L', 'nb_T_S', 'nb_T_OSE', 'nb_T_tot',
                    'taux-bacc-A1', 'taux-bacc-A2', 'taux-bacc-C', 'taux-bacc-D',
                    'taux-bacc-L', 'taux-bacc-OSE', 'taux-bacc-S', 'resultat_global', 'taux_CEPE',
                    'taux_reussite_bepc', 'Montant_caisse-ecole'
                ];

                if (numericFields.includes(header)) {
                    const cleanedValue = value.replace(',', '.').replace(/\s+/g, '');
                    const numValue = parseFloat(cleanedValue);
                    etab[header] = isNaN(numValue) ? '' : numValue;
                } else {
                    etab[header] = value;
                }
            });

            const codeEtab = etab.code_etab || '';
            if (codeEtab && codesUniques.has(codeEtab)) {
                console.warn(`⚠️ Doublon code_etab: ${codeEtab} (ligne ${i+1})`);
                lignesIgnored++;
                continue;
            }
            
            if (codeEtab) {
                codesUniques.add(codeEtab);
            }

            if (!etab.nom_etab || etab.nom_etab === '') {
                etab.nom_etab = `Établissement ${i}`;
            }
            
            if (!etab.cisco || etab.cisco === '') etab.cisco = 'INCONNU';
            if (!etab.commune || etab.commune === '') etab.commune = 'INCONNU';
            
            if (!etab.secteur || etab.secteur === '') {
                etab.secteur = 'Publique';
            } else {
                const secteurLower = etab.secteur.toLowerCase();
                if (secteurLower.includes('public')) {
                    etab.secteur = 'Publique';
                } else if (secteurLower.includes('privé') || secteurLower.includes('prive')) {
                    etab.secteur = 'Privée';
                }
            }

            let lat = parseFloat(etab.y);
            let lng = parseFloat(etab.x);
            
            if (isNaN(lat) || isNaN(lng) || lat === 0 || lng === 0) {
                const minLat = -20.0;
                const maxLat = -19.0;
                const minLng = 46.5;
                const maxLng = 47.5;
                
                const randomLat = minLat + Math.random() * (maxLat - minLat);
                const randomLng = minLng + Math.random() * (maxLng - minLng);
                
                etab.x = randomLng.toFixed(6);
                etab.y = randomLat.toFixed(6);
            } else if (lat < -25 || lat > -12 || lng < 43 || lng > 51) {
                console.warn(`⚠️ Coordonnées invalides pour ${etab.nom_etab}: ${lat}, ${lng}`);
                const minLat = -20.0;
                const maxLat = -19.0;
                const minLng = 46.5;
                const maxLng = 47.5;
                
                const randomLat = minLat + Math.random() * (maxLat - minLat);
                const randomLng = minLng + Math.random() * (maxLng - minLng);
                
                etab.x = randomLng.toFixed(6);
                etab.y = randomLat.toFixed(6);
            }

            etablissements.push(etab);
        }

        console.log(`✅ ${etablissements.length} établissements parsés pour ${niveau}`);
        if (lignesIgnored > 0) {
            console.warn(`⚠️ ${lignesIgnored} lignes ignorées (doublons ou format incorrect)`);
        }

        return etablissements;
    }

    function parseCSVLine(line, separator) {
        const values = [];
        let currentValue = '';
        let inQuotes = false;
        
        for (let j = 0; j < line.length; j++) {
            const char = line[j];
            
            if (char === '"') {
                inQuotes = !inQuotes;
            } else if (char === separator && !inQuotes) {
                values.push(currentValue);
                currentValue = '';
            } else {
                currentValue += char;
            }
        }
        values.push(currentValue);
        
        return values.map(v => v.trim().replace(/^"|"$/g, ''));
    }

    // ==================== CHARGEMENT DES DONNÉES ====================

    async function loadCSVData(niveau) {
        try {
            console.log(`📂 Chargement des données ${niveau}...`);
            
            if (niveauxData[niveau] && niveauxData[niveau].length > 0) {
                console.log(`✅ Données ${niveau} déjà en mémoire: ${niveauxData[niveau].length} établissements`);
                return niveauxData[niveau];
            }
            
            const storedData = loadFromLocalStorage(niveau);
            if (storedData && storedData.length > 0) {
                console.log(`📦 Utilisation des données ${niveau} depuis localStorage (${storedData.length} établissements)`);
                niveauxData[niveau] = storedData;
                return storedData;
            }
            
            const config = columnConfig[niveau];
            if (!config || !config.csvFile) {
                throw new Error(`Configuration manquante pour le niveau ${niveau}`);
            }
            
            console.log(`📤 Chargement depuis: ${config.csvFile}`);
            
            await new Promise(resolve => setTimeout(resolve, 500));
            
            const response = await fetch(config.csvFile);
            
            if (!response.ok) {
                if (response.status === 404) {
                    console.warn(`⚠️ Fichier non trouvé: ${config.csvFile}`);
                    showNotification(`Fichier ${config.csvFile} non trouvé`, 'warning');
                } else {
                    throw new Error(`Erreur HTTP ${response.status}: ${response.statusText}`);
                }
                return [];
            }
            
            const csvText = await response.text();
            
            if (!csvText.trim()) {
                console.warn(`⚠️ Fichier ${niveau} vide`);
                showNotification(`Fichier ${config.csvFile} est vide`, 'warning');
                return [];
            }
            
            console.log(`📄 ${csvText.length.toLocaleString()} caractères lus pour ${niveau}`);
            
            const rawData = parseCSV(csvText, niveau);
            
            if (rawData.length === 0) {
                console.warn(`⚠️ Aucune donnée valide dans le fichier ${niveau}`);
                return [];
            }
            
            const processedData = rawData.map(row => {
                const filteredRow = {};
                
                config.csvColumns.forEach(col => {
                    if (col in row) {
                        filteredRow[col] = row[col];
                    } else {
                        filteredRow[col] = '';
                    }
                });
                
                return filteredRow;
            });
            
            console.log(`✅ ${processedData.length} établissements traités pour ${niveau}`);
            
            saveToLocalStorage(niveau, processedData);
            
            niveauxData[niveau] = processedData;
            
            return processedData;
            
        } catch (error) {
            console.error(`❌ Erreur chargement ${niveau}:`, error);
            showNotification(`Erreur chargement ${niveau}: ${error.message}`, 'error');
            return [];
        }
    }

    // ==================== ITINÉRAIRE AMÉLIORÉ ====================
    function calculateItineraireAdvanced(startPoint, endPoint) {
        if (!window.dashboard || !window.dashboard.map) {
            showNotification("Carte non disponible dans le projet", "error");
            return;
        }

        // Supprimer un ancien itinéraire si déjà présent
        if (window.dashboard.routeControl) {
            window.dashboard.map.removeControl(window.dashboard.routeControl);
        }

        // Créer un nouveau contrôle d'itinéraire
        window.dashboard.routeControl = L.Routing.control({
            waypoints: [
                L.latLng(startPoint.coordinates.lat, startPoint.coordinates.lng),
                L.latLng(endPoint.coordinates.lat, endPoint.coordinates.lng)
            ],
            lineOptions: {
                styles: [{ color: '#27ae60', weight: 5, opacity: 0.9 }]
            },
            show: false,               // ne pas afficher le panneau texte
            addWaypoints: false,       // pas de points intermédiaires ajoutés par clic
            draggableWaypoints: false, // pas de déplacement des points
            fitSelectedRoutes: true    // zoom automatique sur l’itinéraire
        }).addTo(window.dashboard.map);

        // Popup sur les points de départ et d’arrivée
        const startMarker = L.marker([startPoint.coordinates.lat, startPoint.coordinates.lng], {
            icon: L.divIcon({
                className: 'start-marker',
                html: '<i class="fas fa-play-circle" style="color:#2980b9; font-size:24px;"></i>',
                iconSize: [24, 24],
                iconAnchor: [12, 24]
            })
        }).addTo(window.dashboard.map).bindPopup(`<strong>Départ :</strong> ${startPoint.name}`).openPopup();

        const endMarker = L.marker([endPoint.coordinates.lat, endPoint.coordinates.lng], {
            icon: L.divIcon({
                className: 'end-marker',
                html: '<i class="fas fa-flag-checkered" style="color:#e74c3c; font-size:24px;"></i>',
                iconSize: [24, 24],
                iconAnchor: [12, 24]
            })
        }).addTo(window.dashboard.map).bindPopup(`<strong>Arrivée :</strong> ${endPoint.name}`);

        // Nettoyer les marqueurs après 10 secondes pour éviter surcharge
        setTimeout(() => {
            window.dashboard.map.removeLayer(startMarker);
            window.dashboard.map.removeLayer(endMarker);
        }, 10000);

        showNotification("Itinéraire calculé et affiché sur la carte", "success");
    }

    // Fonction pour mettre à jour le résumé ETOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO
    function updateItineraireSummary(startPoint, endPoint, distance, duration) {
        const container = document.getElementById('itineraireSummary');
        
        // S'assurer que le conteneur existe
        if (!container) {
            const summaryDiv = document.createElement('div');
            summaryDiv.id = 'itineraireSummary';
            document.querySelector('.map-container')?.appendChild(summaryDiv) || 
            document.getElementById('map')?.parentElement.appendChild(summaryDiv);
        }
        
        // Noms des points (version courte pour l'affichage)
        const startName = startPoint.type === 'current' ? 
            'Votre position' : 
            startPoint.etablissement?.nom_etab?.split(' ')[0] || 'Départ';
        
        const endName = endPoint.etablissement?.nom_etab?.split(' ')[0] || 'Arrivée';
        
        // HTML Bootstrap pour le résumé d'itinéraire
        const summaryHTML = `
            <div class="card border-0 shadow-sm" style="max-width: 280px;">
                <div class="card-body p-3">
                    <!-- En-tête avec titre et distance/durée -->
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-route text-primary me-1"></i> Itinéraire
                        </h6>
                        <div class="text-end">
                            <div class="fw-bold fs-5">${distance} km</div>
                            <small class="text-muted">${duration}</small>
                        </div>
                    </div>
                    
                    <!-- Points de départ et d'arrivée -->
                    <div class="mb-3">
                        <!-- Point de départ -->
                        <div class="d-flex align-items-start mb-2">
                            <div class="me-2 mt-1">
                                <div class="bg-success rounded-circle d-flex align-items-center justify-content-center" 
                                    style="width: 20px; height: 20px;">
                                    <i class="fas fa-play text-white" style="font-size: 0.6rem;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="small text-muted">Départ</div>
                                <div class="fw-medium">${startName}</div>
                                <div class="small text-truncate" style="max-width: 200px;" 
                                    title="${startPoint.name || startPoint.address || ''}">
                                    ${startPoint.name || startPoint.address || ''}
                                </div>
                            </div>
                        </div>
                        
                        <!-- Point d'arrivée -->
                        <div class="d-flex align-items-start">
                            <div class="me-2 mt-1">
                                <div class="bg-danger rounded-circle d-flex align-items-center justify-content-center" 
                                    style="width: 20px; height: 20px;">
                                    <i class="fas fa-flag-checkered text-white" style="font-size: 0.6rem;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="small text-muted">Arrivée</div>
                                <div class="fw-medium">${endName}</div>
                                <div class="small text-truncate" style="max-width: 200px;" 
                                    title="${endPoint.name || endPoint.address || ''}">
                                    ${endPoint.name || endPoint.address || ''}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Boutons d'action -->
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-outline-danger btn-sm" onclick="window.dashboard.clearItineraire()">
                            <i class="fas fa-times me-1"></i>Effacer
                        </button>
                        <button class="btn btn-primary btn-sm" onclick="showItineraireDetails()">
                            <i class="fas fa-info-circle me-1"></i>Détails
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        // Positionnement absolu si nécessaire
        const summaryElement = document.getElementById('itineraireSummary');
        summaryElement.innerHTML = summaryHTML;
        
        // Ajouter les styles de positionnement si pas déjà présents
        if (!summaryElement.style.position) {
            summaryElement.style.position = 'absolute';
            summaryElement.style.top = '10px';
            summaryElement.style.right = '10px';
            summaryElement.style.zIndex = '1000';
            summaryElement.style.maxWidth = '300px';
        }
    }
    // Nouvelle fonction pour tracer une ligne directe
    function drawDirectLine(startPoint, endPoint) {
        const directLine = L.polyline([
            [startPoint.coordinates.lat, startPoint.coordinates.lng],
            [endPoint.coordinates.lat, endPoint.coordinates.lng]
        ], {
            color: '#3498db',
            weight: 3,
            opacity: 0.7,
            dashArray: '10, 10'
        }).addTo(map);
        
        // Calculer la distance directe
        const distance = map.distance(
            [startPoint.coordinates.lat, startPoint.coordinates.lng],
            [endPoint.coordinates.lat, endPoint.coordinates.lng]
        );
        
        const distanceKm = (distance / 1000).toFixed(2);
        
        // Afficher le résumé
        updateItineraireSummary(startPoint, endPoint, distanceKm, 'Distance directe');
        
        // Stocker la ligne pour pouvoir la supprimer plus tard
        routingControl = {
            line: directLine,
            remove: function() {
                if (this.line) map.removeLayer(this.line);
            }
        };
    }

    // Fonction simplifiée pour afficher le résumé basique (comme dans l'image) ETOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO
    function showSimpleItineraireSummary(distance, duration, startAddress, endAddress) {
        const container = document.getElementById('itineraireSummary');
        
        if (!container) {
            const summaryDiv = document.createElement('div');
            summaryDiv.id = 'itineraireSummary';
            document.body.appendChild(summaryDiv);
        }
        
        const summaryHTML = `
            <div class="card border-0 shadow-sm" style="max-width: 280px;">
                <div class="card-body p-3">
                    <!-- Distance et durée en grand -->
                    <div class="text-center mb-3">
                        <div class="display-6 fw-bold text-primary">${distance} km</div>
                        <div class="text-muted">${duration}</div>
                    </div>
                    
                    <!-- Points de départ/arrivée -->
                    <div class="border-top pt-3">
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-success rounded-circle d-flex align-items-center justify-content-center me-3" 
                                style="width: 24px; height: 24px;">
                                <i class="fas fa-play text-white" style="font-size: 0.7rem;"></i>
                            </div>
                            <div>
                                <div class="small text-muted">Départ</div>
                                <div class="fw-medium text-truncate" style="max-width: 220px;">
                                    ${startAddress}
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center">
                            <div class="bg-danger rounded-circle d-flex align-items-center justify-content-center me-3" 
                                style="width: 24px; height: 24px;">
                                <i class="fas fa-flag-checkered text-white" style="font-size: 0.7rem;"></i>
                            </div>
                            <div>
                                <div class="small text-muted">Arrivée</div>
                                <div class="fw-medium text-truncate" style="max-width: 220px;">
                                    ${endAddress}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Boutons -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                        <button class="btn btn-outline-secondary btn-sm me-2" onclick="window.dashboard.clearItineraire()">
                            <i class="fas fa-times"></i>
                        </button>
                        <button class="btn btn-primary btn-sm" onclick="showItineraireDetails()">
                            <i class="fas fa-ellipsis-h"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        const summaryElement = document.getElementById('itineraireSummary');
        summaryElement.innerHTML = summaryHTML;
        
        // Positionnement
        summaryElement.style.position = 'absolute';
        summaryElement.style.top = '20px';
        summaryElement.style.right = '20px';
        summaryElement.style.zIndex = '1000';
    }

    function clearItineraire() {
        console.log('🗑️ Nettoyage itinéraire');
        
        if (routingControl) {
            if (typeof routingControl.remove === 'function') {
                routingControl.remove();
            } else if (routingControl.line) {
                map.removeLayer(routingControl.line);
            } else if (map.removeControl) {
                map.removeControl(routingControl);
            }
            routingControl = null;
        }
        
        // Supprimer les marqueurs
        map.eachLayer(function(layer) {
            if (layer instanceof L.Marker) {
                const className = layer.options?.icon?.options?.className;
                if (className && (className.includes('route-marker') || className.includes('current-location'))) {
                    map.removeLayer(layer);
                }
            }
        });
        
        // Supprimer le résumé
        const summary = document.getElementById('itineraireSummary');
        if (summary) summary.remove();
        
        showNotification('Itinéraire effacé', 'info');
    }

    // ==================== GÉOLOCALISATION ====================

    function updateCalculateButton() {
        const calculateBtn = document.getElementById('calculateRouteBtn');
        if (!calculateBtn) return;
        
        const startType = document.querySelector('input[name="startPointType"]:checked')?.value;
        
        let isStartValid = false;
        if (startType === 'current') {
            isStartValid = currentUserLocation !== null;
        } else {
            isStartValid = selectedStartEtablissement !== null;
        }
        
        const isEndValid = selectedEndEtablissement !== null;
        
        calculateBtn.disabled = !(isStartValid && isEndValid);
        
        if (!calculateBtn.disabled) {
            const endName = selectedEndEtablissement?.nom_etab?.split(' ')[0] || '';
            calculateBtn.innerHTML = `
                <i class="fas fa-route me-2"></i>Calculer l'itinéraire
                <span class="badge bg-success ms-2">
                    ${startType === 'current' ? 'Position actuelle' : 'Établissement'} → ${endName}
                </span>
            `;
        } else {
            calculateBtn.innerHTML = `
                <i class="fas fa-route me-2"></i>Calculer l'itinéraire
            `;
        }
    }

    function getCurrentLocation() {
        console.log('📍 Obtenir position actuelle');
        
        const locationInfo = document.getElementById('locationInfo');
        const btn = document.querySelector('#currentLocationSection button');
        
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Localisation...';
        }
        
        locationInfo.innerHTML = `
            <div class="text-center">
                <div class="spinner-border spinner-border-sm text-primary me-2"></div>
                <span>Localisation en cours...</span>
            </div>
        `;
        
        if (!navigator.geolocation) {
            locationInfo.innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    La géolocalisation n'est pas supportée par votre navigateur.
                </div>
            `;
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-location-crosshairs me-1"></i>Obtenir ma position';
            }
            return;
        }
        
        // Options améliorées pour la géolocalisation
        const options = {
            enableHighAccuracy: false, // Mettre à false pour éviter l'erreur code 2
            timeout: 15000, // 15 secondes
            maximumAge: 30000 // Utiliser une position mise en cache de moins de 30 secondes
        };
        
        navigator.geolocation.getCurrentPosition(
            function(position) {
                currentUserLocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                
                locationInfo.innerHTML = `
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        Position obtenue avec succès !
                        <div class="small mt-1">
                            Lat: ${currentUserLocation.lat.toFixed(6)}, 
                            Lng: ${currentUserLocation.lng.toFixed(6)}
                        </div>
                    </div>
                `;
                
                if (btn) {
                    btn.innerHTML = '<i class="fas fa-location-crosshairs me-1"></i>Position obtenue';
                    btn.classList.remove('btn-primary');
                    btn.classList.add('btn-success');
                }
                
                updateCalculateButton();
                
            },
            function(error) {
                console.error('Erreur géolocalisation:', error);
                
                let errorMessage = "Impossible d'obtenir votre position.";
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        errorMessage = `
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Permission refusée</strong><br>
                                <small>Veuillez autoriser la géolocalisation dans les paramètres de votre navigateur.</small>
                                <div class="mt-2">
                                    <button class="btn btn-sm btn-outline-warning" onclick="window.dashboard.getCurrentLocation()">
                                        <i class="fas fa-redo me-1"></i>Réessayer
                                    </button>
                                </div>
                            </div>
                        `;
                        break;
                    case error.POSITION_UNAVAILABLE:
                        errorMessage = `
                            <div class="alert alert-warning">
                                <i class="fas fa-map-marker-alt me-2"></i>
                                <strong>Position non disponible</strong><br>
                                <small>Utilisation de la position par défaut (Antananarivo).</small>
                            </div>
                        `;
                        // Position par défaut (Antananarivo)
                        currentUserLocation = {
                            lat: -18.8792,
                            lng: 47.5079
                        };
                        updateCalculateButton();
                        break;
                    case error.TIMEOUT:
                        errorMessage = `
                            <div class="alert alert-warning">
                                <i class="fas fa-clock me-2"></i>
                                <strong>Temps écoulé</strong><br>
                                <small>Utilisation de la position par défaut (Antananarivo).</small>
                            </div>
                        `;
                        // Position par défaut (Antananarivo)
                        currentUserLocation = {
                            lat: -18.8792,
                            lng: 47.5079
                        };
                        updateCalculateButton();
                        break;
                }
                
                locationInfo.innerHTML = errorMessage;
                
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-location-crosshairs me-1"></i>Réessayer';
                    btn.classList.remove('btn-success');
                    btn.classList.add('btn-primary');
                }
            },
            options
        );
    }

    function showAllEndPoints() {
        const currentData = niveauxData[currentLevel] || [];
        const endSelect = document.getElementById('endPointSelect');
        const searchInput = document.getElementById('endPointSearch');
        const infoDiv = document.getElementById('endPointInfo');
        
        if (!endSelect) return;
        
        if (searchInput) searchInput.value = '';
        
        endSelect.innerHTML = '<option value="">Sélectionnez un établissement...</option>';
        
        currentData.forEach((etab, index) => {
            const secteurIcon = etab.secteur === 'Publique' ? 
                '<i class="fas fa-university text-success me-1"></i>' : 
                '<i class="fas fa-store text-danger me-1"></i>';
            
            const option = document.createElement('option');
            option.value = index;
            option.innerHTML = `${secteurIcon} ${etab.nom_etab} - ${etab.commune}`;
            option.dataset.nom = etab.nom_etab;
            option.dataset.commune = etab.commune;
            option.dataset.secteur = etab.secteur;
            option.dataset.eleves = etab.nb_ENF || '0';
            option.dataset.lat = etab.y || '';
            option.dataset.lng = etab.x || '';
            
            endSelect.appendChild(option);
        });
        
        if (infoDiv) {
            infoDiv.innerHTML = `
                <div class="alert alert-info">
                    <i class="fas fa-eye me-2"></i>
                    ${currentData.length} établissement(s) affiché(s)
                </div>
            `;
        }
    }

    // ==================== MODAL ITINÉRAIRE AMÉLIORÉ ====================
    function searchEtablissements(searchTerm) {
        const searchLower = searchTerm.toLowerCase().trim();
        const currentData = niveauxData[currentLevel] || [];
        const endSelect = document.getElementById('endPointSelect');
        const infoDiv = document.getElementById('endPointInfo');
        
        if (!endSelect) return;
        
        if (!searchTerm) {
            showAllEndPoints();
            return;
        }
        
        endSelect.innerHTML = '<option value="">Sélectionnez un établissement...</option>';
        
        const filteredData = currentData.filter(etab => {
            const nomMatch = etab.nom_etab && etab.nom_etab.toLowerCase().includes(searchLower);
            const communeMatch = etab.commune && etab.commune.toLowerCase().includes(searchLower);
            const ciscoMatch = etab.cisco && etab.cisco.toLowerCase().includes(searchLower);
            
            return nomMatch || communeMatch || ciscoMatch;
        });
        
        filteredData.forEach((etab, index) => {
            const secteurIcon = etab.secteur === 'Publique' ? 
                '<i class="fas fa-university text-success me-1"></i>' : 
                '<i class="fas fa-store text-danger me-1"></i>';
            
            const option = document.createElement('option');
            option.value = index;
            option.innerHTML = `${secteurIcon} ${etab.nom_etab} - ${etab.commune} <small class="text-muted">(${etab.cisco})</small>`;
            option.dataset.nom = etab.nom_etab;
            option.dataset.commune = etab.commune;
            option.dataset.secteur = etab.secteur;
            option.dataset.eleves = etab.nb_ENF || '0';
            option.dataset.lat = etab.y || '';
            option.dataset.lng = etab.x || '';
            
            endSelect.appendChild(option);
        });
        
        if (infoDiv) {
            infoDiv.innerHTML = `
                <div class="alert alert-info">
                    <i class="fas fa-search me-2"></i>
                    ${filteredData.length} établissement(s) trouvé(s) pour "${searchTerm}"
                </div>
            `;
        }
    }

    function clearSearch() {
        const searchInput = document.getElementById('endPointSearch');
        if (searchInput) searchInput.value = '';
        showAllEndPoints();
    }

    function initializeItineraireModal() {
        console.log('🎯 Initialisation modal itinéraire amélioré');
        
        // Variables globales pour le modal
        let currentUserLocation = null;
        let selectedEndEtablissement = null;
        let allEndPoints = [];
        
        // Remplir les listes d'établissements
        const currentData = niveauxData[currentLevel] || [];
        const startSelect = document.getElementById('startPointSelect');
        const endSelect = document.getElementById('endPointSelect');
        
        // Remplir le select de départ
        if (startSelect) {
            startSelect.innerHTML = '<option value="">Sélectionner un établissement</option>';
            currentData.forEach((etab, index) => {
                const secteurIcon = etab.secteur === 'Publique' ? 
                    '<i class="fas fa-university text-success me-1"></i>' : 
                    '<i class="fas fa-store text-danger me-1"></i>';
                
                const option = document.createElement('option');
                option.value = index;
                option.innerHTML = `${secteurIcon} ${etab.nom_etab} - ${etab.commune}`;
                option.dataset.nom = etab.nom_etab;
                option.dataset.commune = etab.commune;
                option.dataset.secteur = etab.secteur;
                option.dataset.eleves = etab.nb_ENF || '0';
                option.dataset.lat = etab.y || '';
                option.dataset.lng = etab.x || '';
                
                startSelect.appendChild(option);
            });
        }
        
        // Remplir le select d'arrivée
        if (endSelect) {
            endSelect.innerHTML = '<option value="">Sélectionnez un établissement...</option>';
            currentData.forEach((etab, index) => {
                const secteurIcon = etab.secteur === 'Publique' ? 
                    '<i class="fas fa-university text-success me-1"></i>' : 
                    '<i class="fas fa-store text-danger me-1"></i>';
                
                const option = document.createElement('option');
                option.value = index;
                option.innerHTML = `${secteurIcon} ${etab.nom_etab} - ${etab.commune}`;
                option.dataset.nom = etab.nom_etab;
                option.dataset.commune = etab.commune;
                option.dataset.secteur = etab.secteur;
                option.dataset.eleves = etab.nb_ENF || '0';
                option.dataset.lat = etab.y || '';
                option.dataset.lng = etab.x || '';
                
                endSelect.appendChild(option);
            });
            allEndPoints = Array.from(endSelect.options);
        }
        
        // Mettre à jour les infos du point de départ
        function updateStartEtablissementInfo() {
            const select = document.getElementById('startPointSelect');
            const infoDiv = document.getElementById('startPointInfo');
            
            if (!select || select.value === "") {
                selectedStartEtablissement = null;
                if (infoDiv) infoDiv.innerHTML = '';
                updateCalculateButton();
                return;
            }
            
            const currentData = niveauxData[currentLevel] || [];
            const index = parseInt(select.value);
            
            if (index >= 0 && index < currentData.length) {
                selectedStartEtablissement = currentData[index];
                
                if (infoDiv) {
                    infoDiv.innerHTML = `
                        <div class="alert alert-success">
                            <i class="fas fa-check me-2"></i>
                            <strong>${selectedStartEtablissement.nom_etab}</strong><br>
                            <small>
                                ${selectedStartEtablissement.commune} • ${selectedStartEtablissement.secteur} • 
                                ${selectedStartEtablissement.nb_ENF ? selectedStartEtablissement.nb_ENF + ' élèves' : 'Effectif non disponible'}
                            </small>
                        </div>
                    `;
                }
            } else {
                selectedStartEtablissement = null;
                if (infoDiv) infoDiv.innerHTML = '';
            }
            
            updateCalculateButton();
        }
        
        // Mettre à jour les infos du point d'arrivée
        function updateEndEtablissementInfo() {
            const select = document.getElementById('endPointSelect');
            const infoDiv = document.getElementById('endPointInfo');
            
            if (!select || select.value === "") {
                selectedEndEtablissement = null;
                if (infoDiv) infoDiv.innerHTML = '';
                updateCalculateButton();
                return;
            }
            
            const currentData = niveauxData[currentLevel] || [];
            const index = parseInt(select.value);
            
            if (index >= 0 && index < currentData.length) {
                selectedEndEtablissement = currentData[index];
                
                if (infoDiv) {
                    infoDiv.innerHTML = `
                        <div class="alert alert-success">
                            <i class="fas fa-flag-checkered me-2"></i>
                            <strong>${selectedEndEtablissement.nom_etab}</strong><br>
                            <small>
                                ${selectedEndEtablissement.commune} • ${selectedEndEtablissement.secteur} • 
                                ${selectedEndEtablissement.nb_ENF ? selectedEndEtablissement.nb_ENF + ' élèves' : 'Effectif non disponible'}<br>
                                <i class="fas fa-map-marker-alt me-1"></i>
                                ${selectedEndEtablissement.y ? selectedEndEtablissement.y + ', ' + selectedEndEtablissement.x : 'Coordonnées non disponibles'}
                            </small>
                        </div>
                    `;
                }
            } else {
                selectedEndEtablissement = null;
                if (infoDiv) infoDiv.innerHTML = '';
            }
            
            updateCalculateButton();
        }
        
        // Gérer le changement de type de point de départ
        document.querySelectorAll('input[name="startPointType"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const isCurrentLocation = this.value === 'current';
                const currentSection = document.getElementById('currentLocationSection');
                const etablissementSection = document.getElementById('etablissementStartSection');
                
                if (currentSection) {
                    currentSection.style.display = isCurrentLocation ? 'block' : 'none';
                }
                if (etablissementSection) {
                    etablissementSection.style.display = isCurrentLocation ? 'none' : 'block';
                }
                
                // Réinitialiser les sélections
                if (isCurrentLocation) {
                    document.getElementById('startPointSelect').value = '';
                    selectedStartEtablissement = null;
                    const infoDiv = document.getElementById('startPointInfo');
                    if (infoDiv) infoDiv.innerHTML = '';
                } else {
                    currentUserLocation = null;
                    const locationInfo = document.getElementById('locationInfo');
                    if (locationInfo) locationInfo.innerHTML = '';
                    const title = document.getElementById('startLocationTitle');
                    const info = document.getElementById('startLocationInfo');
                    if (title) title.innerHTML = '<i class="fas fa-school me-2"></i>Sélectionnez un établissement';
                    if (info) info.innerHTML = '<i class="fas fa-map-marker-alt me-1"></i>Choisissez dans la liste ci-dessous';
                }
                
                updateCalculateButton();
            });
        });
        
        // Bouton de géolocalisation
        function getCurrentLocation() {
            const locationInfo = document.getElementById('locationInfo');
            const getLocationBtn = document.getElementById('getLocationBtn');
            
            if (getLocationBtn) {
                getLocationBtn.disabled = true;
                getLocationBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Détection en cours...';
            }
            
            if (locationInfo) {
                locationInfo.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Détection de votre position...';
            }
            
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        currentUserLocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        
                        if (locationInfo) {
                            locationInfo.innerHTML = `
                                <div class="text-success">
                                    <i class="fas fa-check-circle me-1"></i>
                                    Position détectée avec succès !<br>
                                    <small>Lat: ${currentUserLocation.lat.toFixed(6)}, Lng: ${currentUserLocation.lng.toFixed(6)}</small>
                                </div>
                            `;
                        }
                        
                        // Mettre à jour le titre
                        const title = document.getElementById('startLocationTitle');
                        const info = document.getElementById('startLocationInfo');
                        if (title) title.innerHTML = '<i class="fas fa-location-dot me-2"></i>Ma position actuelle';
                        if (info) info.innerHTML = '<i class="fas fa-map-marker-alt me-1"></i>Position GPS détectée';
                        
                        if (getLocationBtn) {
                            getLocationBtn.disabled = false;
                            getLocationBtn.innerHTML = '<i class="fas fa-check-circle me-1"></i>Position obtenue';
                            getLocationBtn.style.backgroundColor = '#90FF00';
                        }
                        
                        updateCalculateButton();
                    },
                    function(error) {
                        console.error('Erreur de géolocalisation:', error);
                        
                        if (locationInfo) {
                            let message = "Impossible d'obtenir votre position. ";
                            switch(error.code) {
                                case error.PERMISSION_DENIED:
                                    message += "Vous avez refusé l'accès à la géolocalisation.";
                                    break;
                                case error.POSITION_UNAVAILABLE:
                                    message += "Les informations de localisation ne sont pas disponibles.";
                                    break;
                                case error.TIMEOUT:
                                    message += "La demande de localisation a expiré.";
                                    break;
                                default:
                                    message += "Une erreur inconnue s'est produite.";
                            }
                            locationInfo.innerHTML = `<div class="text-danger"><i class="fas fa-exclamation-circle me-1"></i>${message}</div>`;
                        }
                        
                        if (getLocationBtn) {
                            getLocationBtn.disabled = false;
                            getLocationBtn.innerHTML = '<i class="fas fa-location-crosshairs me-1"></i>Réessayer';
                        }
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    }
                );
            } else {
                if (locationInfo) {
                    locationInfo.innerHTML = '<div class="text-danger"><i class="fas fa-exclamation-circle me-1"></i>La géolocalisation n\'est pas supportée par votre navigateur.</div>';
                }
                if (getLocationBtn) {
                    getLocationBtn.disabled = false;
                    getLocationBtn.innerHTML = '<i class="fas fa-location-crosshairs me-1"></i>Obtenir ma position';
                }
            }
        }
        
        // Recherche d'établissements pour le départ
        const startSearchInput = document.getElementById('startPointSearch');
        if (startSearchInput) {
            startSearchInput.addEventListener('input', function(e) {
                searchEtablissements(e.target.value, 'startPointSelect');
            });
        }
        
        // Recherche d'établissements pour l'arrivée
        const endSearchInput = document.getElementById('endPointSearch');
        if (endSearchInput) {
            endSearchInput.addEventListener('input', function(e) {
                searchEtablissements(e.target.value, 'endPointSelect');
            });
        }
        
        // Fonction de recherche générique
        function searchEtablissements(searchTerm, selectId) {
            const select = document.getElementById(selectId);
            if (!select) return;
            
            const searchLower = searchTerm.toLowerCase();
            
            // Réinitialiser toutes les options
            Array.from(select.options).forEach(option => {
                option.style.display = 'block';
            });
            
            if (searchTerm.length > 0) {
                Array.from(select.options).forEach(option => {
                    const text = option.textContent.toLowerCase();
                    if (text.includes(searchLower) || option.value === "") {
                        option.style.display = 'block';
                    } else {
                        option.style.display = 'none';
                    }
                });
            }
        }
        
        // Bouton effacer recherche arrivée
        const clearSearchBtn = document.getElementById('clearSearchBtn');
        if (clearSearchBtn) {
            clearSearchBtn.addEventListener('click', function() {
                const searchInput = document.getElementById('endPointSearch');
                if (searchInput) {
                    searchInput.value = '';
                    searchEtablissements('', 'endPointSelect');
                }
            });
        }
        
        // Filtres pour le départ
        const filterStartPublicBtn = document.getElementById('filterStartPublicBtn');
        if (filterStartPublicBtn) {
            filterStartPublicBtn.addEventListener('click', function() {
                filterPoints('Publique', 'startPointSelect');
            });
        }
        
        const filterStartPrivateBtn = document.getElementById('filterStartPrivateBtn');
        if (filterStartPrivateBtn) {
            filterStartPrivateBtn.addEventListener('click', function() {
                filterPoints('Privée', 'startPointSelect');
            });
        }
        
        const showAllStartBtn = document.getElementById('showAllStartBtn');
        if (showAllStartBtn) {
            showAllStartBtn.addEventListener('click', function() {
                showAllPoints('startPointSelect');
            });
        }
        
        // Filtres pour l'arrivée
        const filterPublicBtn = document.getElementById('filterPublicBtn');
        if (filterPublicBtn) {
            filterPublicBtn.addEventListener('click', function() {
                filterPoints('Publique', 'endPointSelect');
            });
        }
        
        const filterPrivateBtn = document.getElementById('filterPrivateBtn');
        if (filterPrivateBtn) {
            filterPrivateBtn.addEventListener('click', function() {
                filterPoints('Privée', 'endPointSelect');
            });
        }
        
        const showAllBtn = document.getElementById('showAllBtn');
        if (showAllBtn) {
            showAllBtn.addEventListener('click', function() {
                showAllPoints('endPointSelect');
            });
        }
        
        // Fonctions de filtrage
        function filterPoints(secteurType, selectId) {
            const select = document.getElementById(selectId);
            if (!select) return;
            
            Array.from(select.options).forEach(option => {
                if (option.value === "") {
                    option.style.display = 'block';
                    return;
                }
                
                const secteur = option.dataset.secteur;
                if (secteur === secteurType) {
                    option.style.display = 'block';
                } else {
                    option.style.display = 'none';
                }
            });
        }
        
        function showAllPoints(selectId) {
            const select = document.getElementById(selectId);
            if (!select) return;
            
            Array.from(select.options).forEach(option => {
                option.style.display = 'block';
            });
        }
        
        // Événements pour les sélections
        if (startSelect) {
            startSelect.addEventListener('change', updateStartEtablissementInfo);
        }
        
        if (endSelect) {
            endSelect.addEventListener('change', updateEndEtablissementInfo);
        }
        
        // Bouton calculer itinéraire
        const calculateRouteBtn = document.getElementById('calculateRouteBtn');
        if (calculateRouteBtn) {
            calculateRouteBtn.addEventListener('click', calculateRoute);
        }
        
        // Obtenir la position actuelle automatiquement
        setTimeout(() => {
            if (document.getElementById('currentLocationRadio')?.checked) {
                getCurrentLocation();
            }
        }, 500);
        
        // Fonction pour mettre à jour le bouton de calcul
        function updateCalculateButton() {
            const calculateBtn = document.getElementById('calculateRouteBtn');
            if (!calculateBtn) return;
            
            const startType = document.querySelector('input[name="startPointType"]:checked');
            const hasStart = startType ? 
                (startType.value === 'current' ? currentUserLocation !== null : selectedStartEtablissement !== null) : 
                false;
            const hasEnd = selectedEndEtablissement !== null;
            
            if (hasStart && hasEnd) {
                calculateBtn.disabled = false;
                calculateBtn.style.opacity = '1';
            } else {
                calculateBtn.disabled = true;
                calculateBtn.style.opacity = '0.6';
            }
        }
        
        // Initialiser le bouton de calcul
        updateCalculateButton();
        
        // Garder la fonction calculateRoute existante
        function calculateRoute() {
            console.log('🛣️ Calcul de l\'itinéraire demandé');
            
            const startType = document.querySelector('input[name="startPointType"]:checked')?.value;
            let startPoint, endPoint;
            
            // Déterminer le point de départ
            if (startType === 'current' && currentUserLocation) {
                startPoint = {
                    type: 'current',
                    coordinates: currentUserLocation,
                    name: 'Position actuelle'
                };
                console.log('📍 Départ depuis la position actuelle');
            } else if (selectedStartEtablissement) {
                const lat = parseFloat(selectedStartEtablissement.y);
                const lng = parseFloat(selectedStartEtablissement.x);
                
                if (isNaN(lat) || isNaN(lng)) {
                    showNotification('Coordonnées GPS invalides pour l\'établissement de départ', 'error');
                    return;
                }
                
                startPoint = {
                    type: 'etablissement',
                    coordinates: { lat, lng },
                    name: selectedStartEtablissement.nom_etab,
                    etablissement: selectedStartEtablissement
                };
                console.log('🏫 Départ depuis établissement:', selectedStartEtablissement.nom_etab);
            } else {
                showNotification('Veuillez sélectionner un point de départ valide', 'warning');
                return;
            }
            
            // Déterminer le point d'arrivée
            if (selectedEndEtablissement) {
                const endLat = parseFloat(selectedEndEtablissement.y);
                const endLng = parseFloat(selectedEndEtablissement.x);
                
                if (isNaN(endLat) || isNaN(endLng)) {
                    showNotification('Coordonnées GPS invalides pour l\'établissement d\'arrivée', 'error');
                    return;
                }
                
                endPoint = {
                    type: 'etablissement',
                    coordinates: { lat: endLat, lng: endLng },
                    name: selectedEndEtablissement.nom_etab,
                    etablissement: selectedEndEtablissement
                };
                console.log('🎯 Arrivée à établissement:', selectedEndEtablissement.nom_etab);
            } else {
                showNotification('Veuillez sélectionner un point d\'arrivée valide', 'warning');
                return;
            }
            
            // Fermer le modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('itineraireModal'));
            if (modal) modal.hide();
            
            // Calculer l'itinéraire
            calculateItineraireAdvanced(startPoint, endPoint);
        }
    }

    // Fonctions auxiliaires pour l'itinéraire
    function updateStartEtablissementInfo() {
        const select = document.getElementById('startPointSelect');
        const infoDiv = document.getElementById('startPointInfo');
        
        if (!select || select.value === "") {
            selectedStartEtablissement = null;
            if (infoDiv) infoDiv.innerHTML = '';
            updateCalculateButton();
            return;
        }
        
        const currentData = niveauxData[currentLevel] || [];
        const index = parseInt(select.value);
        
        if (index >= 0 && index < currentData.length) {
            const etab = currentData[index];
            selectedStartEtablissement = etab;
            
            if (infoDiv) {
                infoDiv.innerHTML = `
                    <div class="alert alert-success">
                        <i class="fas fa-check me-2"></i>
                        <strong>${etab.nom_etab}</strong><br>
                        <small>
                            ${etab.commune} • ${etab.secteur} • 
                            ${etab.nb_ENF ? etab.nb_ENF + ' élèves' : 'Effectif non disponible'}
                        </small>
                    </div>
                `;
            }
        } else {
            selectedStartEtablissement = null;
            if (infoDiv) infoDiv.innerHTML = '';
        }
        
        updateCalculateButton();
    }

    function updateEndEtablissementInfo() {
        const select = document.getElementById('endPointSelect');
        const infoDiv = document.getElementById('endPointInfo');
        
        if (!select || select.value === "") {
            selectedEndEtablissement = null;
            if (infoDiv) infoDiv.innerHTML = '';
            updateCalculateButton();
            return;
        }
        
        const currentData = niveauxData[currentLevel] || [];
        const index = parseInt(select.value);
        
        if (index >= 0 && index < currentData.length) {
            const etab = currentData[index];
            selectedEndEtablissement = etab;
            
            if (infoDiv) {
                infoDiv.innerHTML = `
                    <div class="alert alert-success">
                        <i class="fas fa-flag-checkered me-2"></i>
                        <strong>${etab.nom_etab}</strong><br>
                        <small>
                            ${etab.commune} • ${etab.secteur} • 
                            ${etab.nb_ENF ? etab.nb_ENF + ' élèves' : 'Effectif non disponible'}<br>
                            <i class="fas fa-map-marker-alt me-1"></i>
                            ${etab.y ? etab.y + ', ' + etab.x : 'Coordonnées non disponibles'}
                        </small>
                    </div>
                `;
            }
        } else {
            selectedEndEtablissement = null;
            if (infoDiv) infoDiv.innerHTML = '';
        }
        
        updateCalculateButton();
    }

    function filterEndPoints(secteur) {
        const currentData = niveauxData[currentLevel] || [];
        const endSelect = document.getElementById('endPointSelect');
        const searchInput = document.getElementById('endPointSearch');
        const infoDiv = document.getElementById('endPointInfo');
        
        if (!endSelect) return;
        
        // Réinitialiser la recherche
        if (searchInput) searchInput.value = '';
        
        endSelect.innerHTML = '<option value="">Sélectionnez un établissement...</option>';
        
        const filteredData = currentData.filter(etab => etab.secteur === secteur);
        
        filteredData.forEach((etab, index) => {
            const secteurIcon = etab.secteur === 'Publique' ? 
                '<i class="fas fa-university text-success me-1"></i>' : 
                '<i class="fas fa-store text-danger me-1"></i>';
            
            const option = document.createElement('option');
            option.value = index;
            option.innerHTML = `${secteurIcon} ${etab.nom_etab} - ${etab.commune}`;
            option.dataset.nom = etab.nom_etab;
            option.dataset.commune = etab.commune;
            option.dataset.secteur = etab.secteur;
            option.dataset.eleves = etab.nb_ENF || '0';
            option.dataset.lat = etab.y || '';
            option.dataset.lng = etab.x || '';
            
            endSelect.appendChild(option);
        });
        
        if (infoDiv) {
            infoDiv.innerHTML = `
                <div class="alert alert-info">
                    <i class="fas fa-filter me-2"></i>
                    ${filteredData.length} établissement(s) ${secteur === 'Publique' ? 'public(s)' : 'privé(s)'}
                </div>
            `;
        }
    }

    function showItineraireModal() {
        console.log('🗺️ Affichage modal itinéraire amélioré');
        
        const modalHTML = `
            <div class="modal fade" id="itineraireModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content border-0 rounded-3">
                        <!-- En-tête avec dégradé vert -->
                        <div class="modal-header text-white rounded-top-3" style="background: linear-gradient(135deg, #3E6E4B 0%, #2d5139 100%);">
                            <h5 class="modal-title fw-bold">
                                <i class="fas fa-route me-2"></i>Calculer mon itinéraire
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        
                        <div class="modal-body p-4" style="background-color: #F6F4EC;">
                            <!-- Point de départ -->
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3" style="color: #3E6E4B;">
                                    <i class="fas fa-play-circle me-2"></i>Point de départ
                                </h6>
                                
                                <div class="card border-0 shadow-sm mb-3">
                                    <div class="card-body">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="startPointType" 
                                                id="currentLocationRadio" value="current" checked
                                                style="border-color: #3E6E4B;">
                                            <label class="form-check-label fw-medium d-flex align-items-center" for="currentLocationRadio">
                                                <span class="badge text-success rounded-pill me-2">
                                                    <i class="fas fa-check-circle me-1"></i>
                                                </span>
                                                <span style="color: #949494ff;">Ma position actuelle</span>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="startPointType" 
                                                id="etablissementRadio" value="etablissement"
                                                style="border-color: #3E6E4B;">
                                            <label class="form-check-label fw-medium d-flex align-items-center" for="etablissementRadio">
                                                <span class="badge bg-warning bg-opacity-10 text-success rounded-pill me-2">
                                                    <i class="fas fa-leaf me-1"></i>
                                                </span>
                                                <span style="color: #3E6E4B;">Un établissement</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Section position actuelle -->
                                <div id="currentLocationSection" class="card border-0 shadow-sm mb-3" style="background-color: #FFFFFF; display: block;">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-2" style="color: #3E6E4B; font-size: 0.9rem;" id="startLocationTitle">
                                            <i class="fas fa-location-dot me-2"></i>Ma position actuelle
                                        </h6>
                                        <p class="text-muted small mb-0" id="startLocationInfo">
                                            <i class="fas fa-map-marker-alt me-1"></i>
                                            Cliquez sur "Obtenir ma position" pour détecter
                                        </p>
                                        <div class="mt-2 text-center">
                                            <button class="btn btn-sm" id="getLocationBtn"
                                                    style="background-color: #9EC967; color: #3E6E4B; border: none;">
                                                <i class="fas fa-location-crosshairs me-1"></i>
                                                Obtenir ma position
                                            </button>
                                        </div>
                                        <div id="locationInfo" class="mt-2 small text-success"></div>
                                    </div>
                                </div>
                                
                                <!-- Section établissement (cachée par défaut) -->
                                <div id="etablissementStartSection" class="card border-0 shadow-sm" style="background-color: #FFFFFF; display: none;">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <div class="input-group">
                                                <span class="input-group-text" style="background-color: #F6F4EC; border-color: #9EC967;">
                                                    <i class="fas fa-search" style="color: #3E6E4B;"></i>
                                                </span>
                                                <input type="text" class="form-control border-start-0" 
                                                    id="startPointSearch" 
                                                    placeholder="Rechercher un établissement..."
                                                    style="border-color: #9EC967;">
                                            </div>
                                        </div>
                                        
                                        <select class="form-select border-2 mb-2" id="startPointSelect" size="4"
                                                style="border-color: #9EC967 !important;">
                                            <option value="">Sélectionner un établissement</option>
                                        </select>
                                        
                                        <!-- Filtres rapides départ -->
                                        <div class="mt-3">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <button type="button" class="btn btn-outline-secondary" id="filterStartPublicBtn"
                                                        style="border-color: #9EC967; color: #3E6E4B;">
                                                    <i class="fas fa-university me-1"></i>Public
                                                </button>
                                                <button type="button" class="btn btn-outline-secondary" id="filterStartPrivateBtn"
                                                        style="border-color: #9EC967; color: #3E6E4B;">
                                                    <i class="fas fa-store me-1"></i>Privé
                                                </button>
                                                <button type="button" class="btn btn-outline-secondary" id="showAllStartBtn"
                                                        style="border-color: #9EC967; color: #3E6E4B;">
                                                    <i class="fas fa-eye me-1"></i>Tous
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <div id="startPointInfo" class="mt-2 small text-success"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Point d'arrivée -->
                            <div>
                                <h6 class="fw-bold mb-3" style="color: #3E6E4B;">
                                    <i class="fas fa-flag-checkered me-2"></i>Point d'arrivée
                                </h6>
                                
                                <div class="card border-0 shadow-sm" style="background-color: #FFFFFF;">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <div class="input-group">
                                                <span class="input-group-text" style="background-color: #F6F4EC; border-color: #9EC967;">
                                                    <i class="fas fa-search" style="color: #3E6E4B;"></i>
                                                </span>
                                                <input type="text" class="form-control border-start-0" 
                                                    id="endPointSearch" 
                                                    placeholder="Rechercher un établissement..."
                                                    style="border-color: #9EC967;">
                                                <button class="btn btn-outline-secondary" type="button" id="clearSearchBtn"
                                                        style="border-color: #9EC967; color: #3E6E4B;">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <select class="form-select border-2 mb-2" id="endPointSelect" size="4"
                                                style="border-color: #9EC967 !important;">
                                            <option value="">Sélectionnez un établissement...</option>
                                        </select>
                                        
                                        <!-- Filtres rapides arrivée -->
                                        <div class="mt-3">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <button type="button" class="btn btn-outline-secondary" id="filterPublicBtn"
                                                        style="border-color: #9EC967; color: #3E6E4B;">
                                                    <i class="fas fa-university me-1"></i>Public
                                                </button>
                                                <button type="button" class="btn btn-outline-secondary" id="filterPrivateBtn"
                                                        style="border-color: #9EC967; color: #3E6E4B;">
                                                    <i class="fas fa-store me-1"></i>Privé
                                                </button>
                                                <button type="button" class="btn btn-outline-secondary" id="showAllBtn"
                                                        style="border-color: #9EC967; color: #3E6E4B;">
                                                    <i class="fas fa-eye me-1"></i>Tous
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <div id="endPointInfo" class="mt-2 small text-success"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Pied de page avec bouton principal -->
                        <div class="modal-footer border-0 rounded-bottom-3" style="background-color: #F6F4EC;">
                            <button type="button" class="btn btn-light border" data-bs-dismiss="modal"
                                    style="color: #3E6E4B; border-color: #3E6E4B !important;">
                                <i class="fas fa-times me-1"></i>Annuler
                            </button>
                            <button type="button" class="btn fw-bold shadow-sm" id="calculateRouteBtn" disabled
                                    style="background: linear-gradient(135deg, #9EC967 0%, #90FF00 100%); 
                                        color: #3E6E4B; 
                                        border: none;
                                        padding: 10px 30px;
                                        opacity: 0.6;">
                                <i class="fas fa-route me-2"></i>Calculer l'itinéraire
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        const existingModal = document.getElementById('itineraireModal');
        if (existingModal) {
            existingModal.remove();
        }
        
        document.body.insertAdjacentHTML('beforeend', modalHTML);
        
        const itineraireModal = new bootstrap.Modal(document.getElementById('itineraireModal'));
        itineraireModal.show();
        
        // Initialiser les listeners
        initializeItineraireModal();

        // Attendez que le modal soit visible avant d'initialiser
        setTimeout(() => {
            initializeItineraireModal();
        }, 500);
    }

    function calculateRoute() {
        console.log('🛣️ Calcul de l\'itinéraire demandé');
        
        // Obtenir le type de départ
        const startTypeRadio = document.querySelector('input[name="startPointType"]:checked');
        if (!startTypeRadio) {
            showNotification('Veuillez sélectionner un type de départ', 'warning');
            return;
        }
        
        const startType = startTypeRadio.value;
        let startPoint, endPoint;
        
        // ===== POINT DE DÉPART =====
        if (startType === 'current') {
            if (!currentUserLocation) {
                showNotification('Veuillez d\'abord obtenir votre position', 'warning');
                getCurrentLocation();
                return;
            }
            startPoint = {
                type: 'current',
                coordinates: currentUserLocation,
                name: 'Position actuelle'
            };
        } else if (startType === 'etablissement') {
            if (!selectedStartEtablissement) {
                showNotification('Veuillez sélectionner un établissement de départ', 'warning');
                return;
            }
            const lat = parseFloat(selectedStartEtablissement.y);
            const lng = parseFloat(selectedStartEtablissement.x);
            if (isNaN(lat) || isNaN(lng)) {
                showNotification('Coordonnées invalides pour l\'établissement de départ', 'error');
                return;
            }
            startPoint = {
                type: 'etablissement',
                coordinates: { lat, lng },
                name: selectedStartEtablissement.nom_etab,
                etablissement: selectedStartEtablissement
            };
        }
        
        // ===== POINT D'ARRIVÉE =====
        if (!selectedEndEtablissement) {
            showNotification('Veuillez sélectionner un établissement d\'arrivée', 'warning');
            return;
        }
        const endLat = parseFloat(selectedEndEtablissement.y);
        const endLng = parseFloat(selectedEndEtablissement.x);
        if (isNaN(endLat) || isNaN(endLng)) {
            showNotification('Coordonnées invalides pour l\'établissement d\'arrivée', 'error');
            return;
        }
        endPoint = {
            type: 'etablissement',
            coordinates: { lat: endLat, lng: endLng },
            name: selectedEndEtablissement.nom_etab,
            etablissement: selectedEndEtablissement
        };
        
        // Fermer le modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('itineraireModal'));
        if (modal) modal.hide();
        
        // Calculer l'itinéraire
        calculateItineraireAdvanced(startPoint, endPoint);
    }

    function exportEtablissementData(etablissement) {
        const dataStr = JSON.stringify(etablissement, null, 2);
        const dataUri = 'data:application/json;charset=utf-8,'+ encodeURIComponent(dataStr);
        
        const exportFileDefaultName = `etablissement_${etablissement.code_etab || etablissement.nom_etab.replace(/\s+/g, '_')}.json`;
        
        const linkElement = document.createElement('a');
        linkElement.setAttribute('href', dataUri);
        linkElement.setAttribute('download', exportFileDefaultName);
        linkElement.click();
        
        showNotification('Données exportées en JSON', 'success');
    }

    function showOnMap(lat, lng) {
        if (window.dashboard && window.dashboard.map) {
            const modal = bootstrap.Modal.getInstance(document.getElementById('detailModal'));
            if (modal) modal.hide();
            
            window.dashboard.map.setView([lat, lng], 15);
            
            const marker = L.marker([lat, lng], {
                icon: L.divIcon({
                    className: 'highlight-marker',
                    html: '<i class="fas fa-map-pin" style="color: #e74c3c; font-size: 30px;"></i>',
                    iconSize: [30, 30],
                    iconAnchor: [15, 30]
                })
            }).addTo(window.dashboard.map);
            
            marker.bindPopup('<strong>Établissement sélectionné</strong>').openPopup();
            
            setTimeout(() => {
                window.dashboard.map.removeLayer(marker);
            }, 5000);
        }
    }

    // ==================== AFFICHAGE DÉTAILS MODERNE ====================

    function showDetails(etablissement) {
        console.log('🔍 Affichage des détails pour:', etablissement.nom_etab || etablissement.nom);
        
        const modalBody = document.getElementById('detailModalBody');
        const modalTitle = document.getElementById('detailModalLabel');
        
        modalTitle.innerHTML = `<i class="fas fa-school me-2"></i>${etablissement.nom_etab || etablissement.nom}`;
        
        // Fonction pour formater les valeurs
        const formatValue = (value) => {
            if (value === null || value === undefined || value === '' || value === '???' || value === 0) {
                return '<span class="text-muted fst-italic">Non renseigné</span>';
            }
            return value;
        };
        
        // Fonction pour formater les montants
        const formatMontant = (value) => {
            if (value === null || value === undefined || value === '' || value === '???' || value === 0) {
                return '<span class="text-muted fst-italic">Non renseigné</span>';
            }
            const numValue = Number(value);
            if (!isNaN(numValue)) {
                return new Intl.NumberFormat('fr-MG', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(numValue) + ' MGA';
            }
            return value;
        };

        // NOUVELLE FONCTION: Créer des petits blocs graphiques
        const createMiniCard = (title, value, icon, color, isMontant = false) => {
            const displayValue = isMontant ? formatMontant(value) : formatValue(value);
            return `
                <div class="col-6 col-md-3 mb-3">
                    <div class="card h-100 border-0" style="background-color: #fff;">
                        <div class="card-body text-center p-2">
                            <div class="mb-2" style="color: ${color};">
                                <i class="fas ${icon} fa-lg"></i>
                            </div>
                            <div class="mb-1">
                                <small class="text-muted fw-bold" style="font-size: 0.7rem;">${title}</small>
                            </div>
                            <div class="fw-bold" style="color: #3E6E4B; font-size: 0.9rem;">
                                ${displayValue}
                            </div>
                        </div>
                    </div>
                </div>
            `;
        };

        // Fonction pour créer une section avec mini cartes
        const createMiniCardsSection = (title, cards) => {
            let html = `
                <div class="mb-4">
                    <h6 class="d-flex align-items-center mb-3" style="color:#3E6E4B">
                        <i class="fas fa-chart-pie me-2"></i>${title}
                    </h6>
                    <div class="row g-2">
            `;
            
            cards.forEach(card => {
                html += card;
            });
            
            html += `</div></div>`;
            return html;
        };

        // FONCTION MODIFIÉE: Créer la section caisse école SIMPLIFIÉE
        const createCaisseEcoleMiniCards = () => {
            const montant = etablissement.Montant_caisse_ecole || etablissement.Montant_caisse || 0;
            const rapport = etablissement.rapport_utilisation_caisse_ecole || etablissement.rapport_utilisation || '';
            const montantNum = Number(montant);
            
            // Déterminer l'état et la couleur
            let etat = 'Vide';
            let etatColor = '#a3a3a3';
            let etatIcon = 'fa-times-circle';
            let etatDescription = '';
            
            if (!isNaN(montantNum)) {
                if (montantNum === 0) {
                    etat = 'Vide';
                    etatColor = '#a3a3a3';
                    etatIcon = 'fa-times-circle';
                    etatDescription = 'Aucun fond disponible';
                } else if (montantNum < 500000) {
                    etat = 'Faible';
                    etatColor = '#ffc107';
                    etatIcon = 'fa-exclamation-triangle';
                    etatDescription = 'Fonds insuffisants';
                } else if (montantNum < 2000000) {
                    etat = 'Moyen';
                    etatColor = '#0dcaf0';
                    etatIcon = 'fa-chart-line';
                    etatDescription = 'Fonds acceptables';
                } else {
                    etat = 'Bon';
                    etatColor = '#27ae60';
                    etatIcon = 'fa-check-circle';
                    etatDescription = 'Fonds suffisants';
                }
            }
            
            // Créer les mini cartes pour la caisse école (SEULEMENT 2 CARTES)
            const caisseCards = [
                createMiniCard('Montant disponible', montant, 'fa-money-bill-wave', '#27ae60', true),
                createMiniCard('État des fonds', etat, etatIcon, etatColor)
            ];
            
            let html = createMiniCardsSection("Caisse École", caisseCards);
            
            // Ajouter une carte pour le rapport si disponible
            if (rapport) {
                html += `
                    <div class="col-12">
                        <div class="card border-0 shadow-sm mb-3" style="border-left: 3px solid #27ae60 !important; background-color: #f8fff9;">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-file-alt me-2" style="color: #27ae60;"></i>
                                    <h6 class="mb-0 fw-bold" style="color: #3E6E4B; font-size: 0.9rem;">
                                        Rapport d'utilisation
                                    </h6>
                                </div>
                                <div class="p-2 rounded" style="background-color: #fff; font-size: 0.8rem;">
                                    <p class="mb-0" style="color: #2d5139;">${rapport}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            } else {
                // Afficher une indication si pas de rapport
                html += `
                `;
            }
            
            // Ajouter une note explicative
            html += `
                <div class="col-12">
                    <div class="d-flex align-items-start mt-2">
                        <i class="fas fa-info-circle mt-1 me-2" style="color: #27ae60; font-size: 0.8rem;"></i>
                        <small class="text-muted mb-4" style="font-size: 0.75rem;">
                            ${etatDescription}. La caisse école est gérée par le comité des parents pour financer 
                            les activités pédagogiques et l'entretien de l'établissement.
                        </small>
                    </div>
                </div>
            `;
            
            return html;
        };

        // Fonction pour créer une section de détails classique
        const createDetailSection = (title, fields) => {
            if (!fields || fields.length === 0) return '';
            
            let html = `
                <div class="mb-4">
                    <h6 class="d-flex align-items-center mb-3" style="color:#3E6E4B">
                        <i class="fas fa-info-circle me-2"></i>${title}
                    </h6>
                    <div class="row g-2">
            `;
            
            fields.forEach((field, index) => {
                if (index % 2 === 0 && index > 0) {
                    html += `</div><div class="row g-2">`;
                }
                
                let value;
                if (field.customValue !== undefined) {
                    value = field.customValue;
                } else {
                    value = etablissement[field.key] !== undefined ? etablissement[field.key] : etablissement[field.alternativeKey];
                }
                
                const displayValue = field.isMontant ? formatMontant(value) : formatValue(value);
                
                html += `
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm mb-2" style="background-color: #fff;">
                            <div class="card-body p-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="fw-bold text-muted" style="font-size: 0.8rem;">${field.label}</small>
                                    <span class="badge rounded-pill" style="color: #27ae60; font-size: 0.7rem; background-color: #f0f9f0;">
                                        ${displayValue}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            html += `</div></div>`;
            return html;
        };

        // Déterminer le niveau de l'établissement
        const determineNiveau = (etab) => {
            const hasValue = (key) => {
                const val = etab[key];
                return val !== undefined && val !== null && val !== '' && val !== 0 && val !== '0';
            };
            
            if (hasValue('nb_seconde') || hasValue('nb_Pr_A') || hasValue('nb_Pr_C') || 
                hasValue('nb_Pr_D') || hasValue('nb_Pr_L') || hasValue('nb_Pr_S') || 
                hasValue('nb_T_A') || hasValue('nb_T_D') || hasValue('nb_T_L') || 
                hasValue('nb_T_S') || hasValue('taux_reussite_bacc')) {
                return 'lycee';
            }
            else if (hasValue('nb_classe_6em') || hasValue('nb_classe_5em') || 
                    hasValue('nb_classe_4em') || hasValue('nb_classe_3em') ||
                    hasValue('taux_reussite_bepc')) {
                return 'college';
            }
            else if (hasValue('nb_classe_12em') || hasValue('nb_classe_11em') || 
                    hasValue('nb_classe_10em') || hasValue('nb_classe_9em') ||
                    hasValue('nb_classe_8em') || hasValue('nb_classe_7em') ||
                    hasValue('taux_reussite_cepe')) {
                return 'primaire';
            }
            else if (hasValue('nb_classe_petite_section') || hasValue('nb_classe_moyenne_section') || 
                    hasValue('nb_classe_grande_section')) {
                return 'prescolaire';
            }
            
            const nom = (etab.nom_etab || etab.nom || '').toLowerCase();
            if (nom.includes('lycée') || nom.includes('lycee') || nom.includes('lgt') || nom.includes('terminal')) {
                return 'lycee';
            } else if (nom.includes('collège') || nom.includes('college') || nom.includes('ceg')) {
                return 'college';
            } else if (nom.includes('primaire') || nom.includes('ep.p') || nom.includes('ep ')) {
                return 'primaire';
            } else if (nom.includes('maternelle') || nom.includes('jardin') || nom.includes('petite section')) {
                return 'prescolaire';
            }
            
            return 'primaire';
        };

        const niveau = determineNiveau(etablissement);
        console.log(`📚 Niveau détecté: ${niveau}`);
        
        // Fonction pour traduire le niveau en français
        const getNiveauLabel = (niveau) => {
            const niveaux = {
                'prescolaire': 'Préscolaire',
                'primaire': 'Primaire',
                'college': 'Collège',
                'lycee': 'Lycée'
            };
            return niveaux[niveau] || niveau;
        };

        // Créer les mini cartes pour les informations principales
        const createMainInfoMiniCards = () => {
            const cards = [
                createMiniCard('Code', etablissement.code_etab, 'fa-hashtag', '#27ae60'),
                createMiniCard('Secteur', etablissement.secteur, 'fa-map-marker-alt', '#27ae60'),
                createMiniCard('CISCO', etablissement.cisco, 'fa-building', '#27ae60'),
                createMiniCard('Commune', etablissement.commune, 'fa-city', '#27ae60'),
                createMiniCard('ZAP', etablissement.zap, 'fa-users', '#27ae60'),
                createMiniCard('Fokontany', etablissement.fokontany, 'fa-home', '#27ae60'),
                createMiniCard('Niveau', getNiveauLabel(niveau), 'fa-graduation-cap', '#27ae60'),
                createMiniCard('Élèves', etablissement.nb_ENF || etablissement.eleves, 'fa-user-graduate', '#27ae60')
            ];
            
            return createMiniCardsSection("Aperçu Général", cards);
        };

        // Sections pour les informations détaillées
        const sectionsDetaillees = [
            {
                title: "Contact et Direction",
                fields: [
                    { key: "Nom_prenoms_DIR", label: "Nom du Directeur" },
                    { key: "Contact_DIR", label: "Contact Directeur" },
                    { key: "adresse_Etab", label: "Adresse Établissement" },
                    { key: "x", label: "Longitude" },
                    { key: "y", label: "Latitude" }
                ]
            }
        ];

        // Créer les mini cartes pour le personnel selon le niveau
        const createPersonnelMiniCards = () => {
            let personnelCards = [
                createMiniCard('Enseignants', etablissement.nb_Ens_foncts || etablissement.personnel, 'fa-chalkboard-teacher', '#27ae60'),
                createMiniCard('Admin Fonctionnaire', etablissement.nb_PA_Fonct, 'fa-user-tie', '#27ae60'),
                createMiniCard('Admin Non Fonctionnaire', etablissement.nb_PA_NonFonct, 'fa-user', '#27ae60'),
                createMiniCard('Bénévoles', etablissement.nb_Bénevoles, 'fa-hands-helping', '#27ae60')
            ];
            
            // Ajouter le total si disponible
            if (etablissement.effectif_total_Personnels) {
                personnelCards.push(
                    createMiniCard('Total Personnel', etablissement.effectif_total_Personnels, 'fa-users', '#27ae60')
                );
            }
            
            return createMiniCardsSection("Personnel", personnelCards);
        };

        // Construire le contenu HTML
        let html = `
            <div class="container-fluid">
                ${createMainInfoMiniCards()}
                ${createCaisseEcoleMiniCards()}
        `;
        
        // Ajouter les sections détaillées
        sectionsDetaillees.forEach(section => {
            html += createDetailSection(section.title, section.fields);
        });
        
        // Ajouter les cartes du personnel
        html += createPersonnelMiniCards();
        
        // Ajouter les qualifications
        const qualifications = [
            { key: "LAPEN", label: "LAPEN", icon: "fa-award", color: "#27ae60" },
            { key: "MAPEN", label: "MAPEN", icon: "fa-medal", color: "#27ae60" },
            { key: "BAC", label: "BAC", icon: "fa-certificate", color: "#27ae60" },
            { key: "BTS", label: "BTS", icon: "fa-graduation-cap", color: "#27ae60" },
            { key: "M1", label: "Master 1", icon: "fa-university", color: "#27ae60" },
            { key: "M2", label: "Master 2", icon: "fa-university", color: "#27ae60" },
            { key: "INGENIEUR", label: "Ingénieur", icon: "fa-cogs", color: "#27ae60" },
            { key: "DOCTORAT", label: "Doctorat", icon: "fa-user-graduate", color: "#27ae60" }
        ];
        
        const qualificationCards = qualifications.map(q => 
            createMiniCard(q.label, etablissement[q.key], q.icon, q.color)
        );
        
        html += createMiniCardsSection("Qualifications des enseignants et des personnels", qualificationCards);
        
        // Fermer le container
        html += `</div>`;
        
        // Ajouter les boutons d'action avec design amélioré
        html += `            
            <div class="mt-3 text-center">
                <small class="text-muted">
                    <i class="fas fa-info-circle me-1"></i>
                    Dernière mise à jour: ${new Date().toLocaleDateString('fr-FR')}
                </small>
            </div>
        `;

        modalBody.innerHTML = html;
        
        const modal = new bootstrap.Modal(document.getElementById('detailModal'));
        modal.show();

        document.getElementById("itineraireFromHereBtn").addEventListener("click", function() {
            // Vérifier que l'établissement a des coordonnées
            const lat = parseFloat(etablissement.y);
            const lng = parseFloat(etablissement.x);
            if (isNaN(lat) || isNaN(lng)) {
                showNotification("Coordonnées GPS non disponibles pour cet établissement", "error");
                return;
            }

            // Fermer le modal détails
            const modal = bootstrap.Modal.getInstance(document.getElementById('detailModal'));
            if (modal) modal.hide();

            // Ouvrir directement l'itinéraire avec ta logique existante
            // Exemple simple avec Google Maps :
            window.open(`https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}&travelmode=driving`, "_blank");

            // OU si tu veux utiliser ton modal itinéraire avancé :
            // showItineraireModal();
        });


    }

    // ==================== AFFICHAGE TABLEAU ====================

    function updateEtablissementTable(etablissements) {
        const tbody = document.getElementById('etablissementTable');
        const statsSummary = document.getElementById('statsSummary');
        
        if (!tbody) {
            console.error('❌ Tableau non trouvé (#etablissementTable)');
            return;
        }
        
        if (!etablissements || etablissements.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <div class="py-4">
                            <div class="mb-3">
                                <i class="fas fa-school fa-3x" style="color: #9EC967;"></i>
                            </div>
                            <h6 class="fw-bold mb-2" style="color: #3E6E4B;">Aucun établissement trouvé</h6>
                            <p class="text-muted mb-0">Ajustez vos filtres de recherche</p>
                        </div>
                    </td>
                </tr>
            `;
            if (statsSummary) {
                statsSummary.textContent = "Aucun établissement trouvé";
            }
            return;
        }
        
        let html = '';
        let totalEleves = 0;
        let publicCount = 0;
        let priveCount = 0;
        let ciscoStats = {};
        
        etablissements.forEach((etab, index) => {
            const secteurBadge = etab.secteur === 'Publique' 
                ? `<span class="badge rounded-pill px-3 py-3 d-flex align-items-center justify-content-center" style="background-color: #fafafaff; color: #3E6E4B; width: 80px;">
                    Public
                </span>` 
                : `<span class="badge rounded-pill px-3 py-3 d-flex align-items-center justify-content-center" style="background-color: #fafafaff; color: #2ECC71; width: 80px;">
                    Privé
                </span>`;
            
            const elevesCount = parseInt(etab.nb_ENF) || 0;
            totalEleves += elevesCount;
            
            if (etab.secteur === 'Publique') {
                publicCount++;
            } else if (etab.secteur === 'Privée') {
                priveCount++;
            }
            
            const cisco = etab.cisco || 'Non spécifié';
            ciscoStats[cisco] = (ciscoStats[cisco] || 0) + 1;
            
            const elevesDisplay = elevesCount > 0 
                ? `<div class="d-flex align-items-center">
                    <div>
                        <div class="fw-bold" style="color: #3E6E4B;">${formatValue(elevesCount)}</div>
                        <small class="text-muted">élèves</small>
                    </div>
                </div>`
                : `<div class="fw-bold" style="color: #3E6E4B;">${formatValue(elevesCount)}</div>
                    <small class="text-muted">élèves</small>`;
            
            const rowClass = index % 2 === 0 ? '' : 'bg-white';
            
            html += `
                <tr class="${rowClass}">
                    <td class="ps-3 py-3" style="max-width: 220px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" 
                                    style="background-color: ${etab.secteur === 'Publique' ? '#9EC967' : '#90FF00'}; width: 40px; height: 40px;">
                                    <i class="fas ${etab.secteur === 'Publique' ? 'fa-university' : 'fa-store'} text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="fw-bold mb-1 text-truncate" style="color: #3E6E4B; max-width: 180px;">
                                    ${etab.nom_etab || 'Nom non disponible'}
                                </div>
                                ${etab.commune ? `<small class="text-muted"><i class="fas fa-map-marker-alt me-1"></i>${etab.commune}</small>` : ''}
                            </div>
                        </div>
                    </td>
                    <td class="py-3">
                        <div class="d-flex align-items-center">
                            <div>
                                <div class="fw-medium" style="color: #3E6E4B;">${cisco}</div>
                                <small class="text-muted">CISCO</small>
                            </div>
                        </div>
                    </td>
                    <td class="py-3">
                        <div class="d-flex justify-content-center">
                            ${secteurBadge}
                        </div>
                    </td>
                    <td class="py-3">
                        ${elevesDisplay}
                    </td>
                    <td class="pe-3 py-3">
                        <button class="btn btn-sm py-3 w-100 d-flex align-items-center justify-content-center rounded-pill" 
                                onclick="window.dashboard.showDetails(${JSON.stringify(etab).replace(/"/g, '&quot;')})"
                                style="background-color: #fafafaff; color: #3E6E4B; border: none;">
                            <i class="fas fa-eye"></i>
                        </button>
                    </td>
                </tr>
            `;
        });
        
        tbody.innerHTML = html;
        
        const countElement = document.getElementById('etablissementCount');
        if (countElement) {
            countElement.textContent = etablissements.length;
        }
        
        if (statsSummary) {
            const avgEleves = Math.round(totalEleves / etablissements.length) || 0;
            statsSummary.textContent = `${etablissements.length} établissements • ${totalEleves} élèves • ${avgEleves} élèves/établissement`;
        }
        
        const secteurStats = document.getElementById('secteurStats');
        if (secteurStats) {
            secteurStats.textContent = `Public: ${publicCount} | Privé: ${priveCount}`;
        }
        
        const ciscoStatsText = document.getElementById('ciscoStats');
        if (ciscoStatsText) {
            const uniqueCiscos = Object.keys(ciscoStats).length;
            ciscoStatsText.textContent = `${uniqueCiscos} CISCO uniques`;
        }
        
        const secteurPercentage = document.getElementById('secteurPercentage');
        if (secteurPercentage && etablissements.length > 0) {
            const total = publicCount + priveCount;
            const publicPercent = Math.round((publicCount / total) * 100);
            secteurPercentage.innerHTML = `${publicPercent}%`;
        }
        
        initializeCharts(etablissements);
    }

    // ==================== STATISTIQUES ====================

    function updateStats(etablissements) {
        const statsContainer = document.getElementById('statsContainer');
        if (!statsContainer) {
            console.error('❌ Conteneur stats non trouvé (#statsContainer)');
            return;
        }
        
        const totalEtablissements = etablissements.length;
        const totalEleves = etablissements.reduce((sum, e) => sum + (parseInt(e.nb_ENF) || 0), 0);
        const totalPersonnel = etablissements.reduce((sum, e) => sum + (parseInt(e.effectif_total_Personnels) || 0), 0);
        const totalCommunes = new Set(etablissements.filter(e => e.commune && e.commune !== 'INCONNU').map(e => e.commune)).size;
        const publicCount = etablissements.filter(e => e.secteur === 'Publique').length;
        const priveCount = etablissements.filter(e => e.secteur === 'Privée').length;
        const publicPercentage = totalEtablissements > 0 ? Math.round((publicCount / totalEtablissements) * 100) : 0;
        const privePercentage = totalEtablissements > 0 ? Math.round((priveCount / totalEtablissements) * 100) : 0;
        
        const statsHTML = `
            <div class="col">
                <div class="card h-100 border-0" style="border-top: 4px solid #229954; background-color: #F6F4EC;">
                    <div class="card-body d-flex align-items-center p-3">
                        <div class="me-3" style="color: #229954;">
                            <i class="fas fa-school fa-2x"></i>
                        </div>
                        <div>
                            <div class="text-muted small mb-1">Établissements</div>
                            <div class="h4 fw-bold mb-0" style="color: #3E6E4B;">${totalEtablissements}</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col">
                <div class="card h-100 border-0" style="border-top: 4px solid #229954; background-color: #F6F4EC;">
                    <div class="card-body d-flex align-items-center p-3">
                        <div class="me-3" style="color: #229954;">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                        <div>
                            <div class="text-muted small mb-1">Élèves</div>
                            <div class="h4 fw-bold mb-0" style="color: #3E6E4B;">${totalEleves.toLocaleString('fr-MG')}</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col">
                <div class="card h-100 border-0" style="border-top: 4px solid #229954; background-color: #F6F4EC;">
                    <div class="card-body d-flex align-items-center p-3">
                        <div class="me-3" style="color: #229954;">
                            <i class="fas fa-chalkboard-teacher fa-2x"></i>
                        </div>
                        <div>
                            <div class="text-muted small mb-1">Personnel</div>
                            <div class="h4 fw-bold mb-0" style="color: #3E6E4B;">${totalPersonnel.toLocaleString('fr-MG')}</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col">
                <div class="card h-100 border-0" style="border-top: 4px solid #229954; background-color: #F6F4EC;">
                    <div class="card-body d-flex align-items-center p-3">
                        <div class="me-3" style="color: #229954;">
                            <i class="fas fa-map-marker-alt fa-2x"></i>
                        </div>
                        <div>
                            <div class="text-muted small mb-1">Communes</div>
                            <div class="h4 fw-bold mb-0" style="color: #3E6E4B;">${totalCommunes}</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col">
                <div class="card h-100 border-0" style="border-top: 4px solid #229954; background-color: #F6F4EC;">
                    <div class="card-body d-flex align-items-center p-3">
                        <div class="me-3" style="color: #229954;">
                            <i class="fas fa-university fa-2x"></i>
                        </div>
                        <div>
                            <div class="text-muted small mb-1">Public</div>
                            <div class="h4 fw-bold mb-0" style="color: #3E6E4B;">${publicCount}</div>
                            <div class="small" style="color: #3E6E4B;">${publicPercentage}%</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col">
                <div class="card h-100 border-0" style="border-top: 4px solid #229954; background-color: #F6F4EC;">
                    <div class="card-body d-flex align-items-center p-3">
                        <div class="me-3" style="color: #229954;">
                            <i class="fas fa-store fa-2x"></i>
                        </div>
                        <div>
                            <div class="text-muted small mb-1">Privé</div>
                            <div class="h4 fw-bold mb-0" style="color: #3E6E4B;">${priveCount}</div>
                            <div class="small" style="color: #3E6E4B;">${privePercentage}%</div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        statsContainer.innerHTML = statsHTML;
    }

    // ==================== GRAPHIQUES ====================

    function initializeCharts(etablissements) {
        const ciscoCtx = document.getElementById('ciscoChart')?.getContext('2d');
        const secteurCtx = document.getElementById('secteurChart')?.getContext('2d');
        
        if (!ciscoCtx && !secteurCtx) return;
        
        const ciscoCounts = {};
        etablissements.forEach(etab => {
            const cisco = etab.cisco || 'INCONNU';
            ciscoCounts[cisco] = (ciscoCounts[cisco] || 0) + 1;
        });

        const sortedCiscos = Object.entries(ciscoCounts)
            .sort((a, b) => b[1] - a[1])
            .slice(0, 10);

        const publicCount = etablissements.filter(e => e.secteur === 'Publique').length;
        const priveCount = etablissements.filter(e => e.secteur === 'Privée').length;
        const totalEtablissements = etablissements.length;

        // Mettre à jour le pourcentage CISCO
        const ciscoPercentage = document.getElementById('ciscoPercentage');
        if (ciscoPercentage && totalEtablissements > 0) {
            const topCisco = sortedCiscos[0];
            if (topCisco) {
                const topCiscoPercent = Math.round((topCisco[1] / totalEtablissements) * 100);
                ciscoPercentage.innerHTML = `${topCiscoPercent}%`;
            }
        }

        // Mettre à jour le pourcentage secteur
        const secteurPercentage = document.getElementById('secteurPercentage');
        if (secteurPercentage && totalEtablissements > 0) {
            const publicPercent = Math.round((publicCount / totalEtablissements) * 100);
            secteurPercentage.innerHTML = `${publicPercent}%`;
        }

        // Graphique CISCO
        if (ciscoCtx) {
            if (window.ciscoChartInstance) window.ciscoChartInstance.destroy();
            
            window.ciscoChartInstance = new Chart(ciscoCtx, {
                type: 'doughnut',
                data: {
                    labels: sortedCiscos.map(item => item[0]),
                    datasets: [{
                        data: sortedCiscos.map(item => item[1]),
                        backgroundColor: [
                            '#3E6E4B', '#9EC967', '#90FF00', '#4CAF50', '#8BC34A',
                            '#CDDC39', '#FFEB3B', '#FFC107', '#FF9800', '#FF5722'
                        ],
                        borderWidth: 2,
                        borderColor: '#F6F4EC'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: {
                        legend: { 
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#3E6E4B',
                            titleColor: '#FFFFFF',
                            bodyColor: '#FFFFFF',
                            borderColor: '#9EC967',
                            borderWidth: 1,
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = etablissements.length;
                                    const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                                    return `${label}: ${value} établissements (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        }

        // Graphique Secteur
        if (secteurCtx) {
            if (window.secteurChartInstance) window.secteurChartInstance.destroy();
            
            window.secteurChartInstance = new Chart(secteurCtx, {
                type: 'doughnut',
                data: {
                    labels: [`Public (${publicCount})`, `Privé (${priveCount})`],
                    datasets: [{
                        data: [publicCount, priveCount],
                        backgroundColor: ['#3E6E4B', '#90FF00'],
                        borderWidth: 2,
                        borderColor: '#F6F4EC'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: {
                        legend: { 
                            position: 'bottom',
                            labels: {
                                padding: 15,
                                usePointStyle: true,
                                font: {
                                    size: 11
                                },
                                color: '#3E6E4B'
                            }
                        },
                        tooltip: {
                            backgroundColor: '#3E6E4B',
                            titleColor: '#FFFFFF',
                            bodyColor: '#FFFFFF',
                            borderColor: '#9EC967',
                            borderWidth: 1,
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = publicCount + priveCount;
                                    const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                                    return `${label}: ${value} établissements (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        }
    }

    // ==================== CARTE ====================

    function initMap() {
        console.log('🗺️ Initialisation de la carte...');
        
        try {
            const mapContainer = document.getElementById('map');
            if (!mapContainer) {
                console.error('❌ Conteneur de carte non trouvé (#map)');
                return null;
            }

            const mapInstance = L.map('map', {
                center: [-19.5, 47.0],
                zoom: 9,
                zoomControl: true,
                attributionControl: true
            });

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributeurs',
                maxZoom: 18,
                minZoom: 8
            }).addTo(mapInstance);

            L.control.locate({
                position: 'topleft',
                strings: {
                    title: "Me localiser"
                },
                locateOptions: {
                    maxZoom: 16,
                    enableHighAccuracy: true
                }
            }).addTo(mapInstance);

            L.control.scale({
                imperial: false,
                metric: true
            }).addTo(mapInstance);

            markerLayer = L.layerGroup().addTo(mapInstance);

            console.log('✅ Carte Leaflet initialisée avec succès');
            return mapInstance;
            
        } catch (error) {
            console.error('❌ Erreur lors de l\'initialisation de la carte:', error);
            showNotification('Erreur d\'initialisation de la carte: ' + error.message, 'error');
            return null;
        }
    }

    function updateMap(etablissements) {
        console.log('📍 Mise à jour de la carte avec', etablissements.length, 'établissements');
        
        if (!map) {
            map = initMap();
            if (!map) {
                console.error('❌ Impossible d\'initialiser la carte');
                return;
            }
        }

        if (markerLayer) {
            markerLayer.clearLayers();
        } else {
            markerLayer = L.layerGroup().addTo(map);
        }

        mapMarkers = [];
        let bounds = L.latLngBounds([]);
        let markersAdded = 0;

        if (etablissements.length === 0) {
            console.log('Aucun établissement à afficher sur la carte');
            return;
        }

        const createIcon = (secteur) => {
            const isPublic = secteur === 'Publique';
            const iconColor = isPublic ? '#27ae60' : '#90FF00';
            const iconSize = 12;
            
            const iconHtml = `
                <div style="
                    color: ${iconColor}; 
                    font-size: ${iconSize}px;
                    text-shadow: 0px 1px 2px rgba(0,0,0,0.5);
                    display: block;
                    line-height: 1;
                    background: transparent;
                    border: none;
                    width: ${iconSize}px;
                    height: ${iconSize}px;
                ">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
            `;
            
            const iconAnchorX = iconSize / 2;
            const iconAnchorY = iconSize;
            
            return L.divIcon({
                className: isPublic ? 'marker-public' : 'marker-prive',
                html: iconHtml,
                iconSize: [iconSize, iconSize],
                iconAnchor: [iconAnchorX, iconAnchorY],
                popupAnchor: [0, -iconSize]
            });
        };

        etablissements.forEach((etab, index) => {
            let lat = parseFloat(etab.y);
            let lng = parseFloat(etab.x);
            
            if (isNaN(lat) || isNaN(lng)) {
                console.warn(`Coordonnées invalides pour ${etab.nom_etab}`);
                return;
            }

            if (lat < -25 || lat > -12 || lng < 43 || lng > 51) {
                console.warn(`Coordonnées hors limites pour ${etab.nom_etab}`);
                return;
            }

            const icon = createIcon(etab.secteur);
            
const popupContent = `
    <div class="container-fluid p-0" style="min-width: 280px;">
        <!-- En-tête avec nom de l'établissement -->
        <div class="bg-success text-white p-3 rounded-top">
            <div class="d-flex align-items-center mb-2">
                <h6 class="mb-0 fw-bold">${etab.nom_etab || 'Établissement sans nom'}</h6>
            </div>
            <div>
                <span class="badge ${etab.secteur === 'Publique' ? 'bg-light text-success' : 'bg-success text-light'}">
                    ${etab.secteur === 'Publique' ? 'Public' : 'Privé'}
                </span>
            </div>
        </div>
        
        <!-- Contenu des informations -->
        <div class="p-3 bg-white">
            <div class="mb-3">
                <div class="d-flex align-items-center mb-2">
                    <div class="bg-light rounded-circle p-2 me-2">
                    </div>
                    <div>
                        <small class="text-muted d-block">CISCO</small>
                        <strong class="text-dark">${etab.cisco || 'Non spécifié'}</strong>
                    </div>
                </div>
            </div>
            
            <div class="row g-2 mb-3">
                <div class="col-6">
                    <div class="border rounded p-2 text-center bg-light">
                        <div class="text-success mb-1">
                        </div>
                        <small class="text-muted d-block">Élèves</small>
                        <strong class="text-dark fs-6">${etab.nb_ENF || '0'}</strong>
                    </div>
                </div>
                <div class="col-6">
                    <div class="border rounded p-2 text-center bg-light">
                        <div class="text-success mb-1">
                        </div>
                        <small class="text-muted d-block">Personnel</small>
                        <strong class="text-dark fs-6">${etab.effectif_total_Personnels || '0'}</strong>
                    </div>
                </div>
            </div>
            
            <!-- Bouton d'action -->
            <button class="btn btn-success w-100 d-flex align-items-center justify-content-center"
                    onclick="window.dashboard.showDetails(${JSON.stringify(etab).replace(/"/g, '&quot;')});"
                    style="background-color: #3E6E4B; border-color: #3E6E4B;">
                <i class="fas fa-eye me-2"></i>
                Voir les détails complets
            </button>
        </div>
        
        <!-- Footer léger -->
        <div class="bg-light py-2 px-3 rounded-bottom">
            <small class="text-muted">
                <i class="fas fa-info-circle me-1"></i>
                Cliquez sur le marqueur pour fermer
            </small>
        </div>
    </div>
`;

            const marker = L.marker([lat, lng], { 
                icon: icon,
                title: `${etab.nom_etab || 'Établissement'} (${etab.secteur === 'Publique' ? 'Public' : 'Privé'})`
            })
            .bindPopup(popupContent)
            .addTo(markerLayer);

            marker.on('mouseover', function() {
                this.openPopup();
            });

            mapMarkers.push(marker);
            bounds.extend([lat, lng]);
            markersAdded++;
        });

        if (markersAdded > 0) {
            if (markersAdded === 1) {
                const center = bounds.getCenter();
                map.setView(center, 13);
            } else {
                map.fitBounds(bounds, { 
                    padding: [50, 50],
                    maxZoom: 12
                });
            }
        } else {
            map.setView([-19.5, 47.0], 9);
            console.log('Aucun marqueur valide à afficher');
        }

        console.log(`📍 ${markersAdded} marqueurs ajoutés à la carte (sur ${etablissements.length} établissements)`);
    }

    // ==================== FONCTIONS DE RECHERCHE ====================

    function applySearch() {
        console.log('🔍 Application de la recherche...');
        
        const searchTerm = document.getElementById('searchFilter')?.value || '';
        const ciscoFilter = document.getElementById('ciscoFilter')?.value || 'all';
        const secteurFilter = document.getElementById('secteurFilter')?.value || 'all';
        
        const currentData = niveauxData[currentLevel] || [];
        
        let filteredData = currentData.filter(etab => {
            // Filtre par recherche textuelle
            if (searchTerm.trim() !== '') {
                const searchLower = searchTerm.toLowerCase();
                const nomMatch = etab.nom_etab && etab.nom_etab.toLowerCase().includes(searchLower);
                const communeMatch = etab.commune && etab.commune.toLowerCase().includes(searchLower);
                const ciscoMatch = etab.cisco && etab.cisco.toLowerCase().includes(searchLower);
                
                if (!nomMatch && !communeMatch && !ciscoMatch) {
                    return false;
                }
            }
            
            // Filtre CISCO
            if (ciscoFilter !== 'all' && etab.cisco !== ciscoFilter) {
                return false;
            }
            
            // Filtre secteur
            if (secteurFilter !== 'all' && etab.secteur !== secteurFilter) {
                return false;
            }
            
            return true;
        });
        
        if (filteredData.length === 0) {
            showNotification('Aucun établissement trouvé avec ces critères', 'warning');
            filteredData = currentData;
        } else if (searchTerm.trim() !== '') {
            showNotification(`${filteredData.length} établissements trouvés pour "${searchTerm}"`, 'success');
        }
        
        updateStats(filteredData);
        updateEtablissementTable(filteredData);
        initializeCharts(filteredData);
        updateMap(filteredData);
    }

    function clearSearch() {
        console.log('🧹 Effacement de la recherche...');
        
        document.getElementById('searchFilter').value = '';
        
        // Réappliquer les filtres sans la recherche
        applyFilters();
        
        showNotification('Recherche effacée', 'info');
    }

    // ==================== FONCTIONS DE FILTRAGE ====================

    function applyFilters() {
        console.log('🔍 Application des filtres...');
        
        const searchTerm = document.getElementById('searchFilter')?.value || '';
        const ciscoFilter = document.getElementById('ciscoFilter')?.value || 'all';
        const secteurFilter = document.getElementById('secteurFilter')?.value || 'all';
        
        const currentData = niveauxData[currentLevel] || [];
        
        let filteredData = currentData.filter(etab => {
            // Filtre par recherche textuelle
            if (searchTerm.trim() !== '') {
                const searchLower = searchTerm.toLowerCase();
                const nomMatch = etab.nom_etab && etab.nom_etab.toLowerCase().includes(searchLower);
                const communeMatch = etab.commune && etab.commune.toLowerCase().includes(searchLower);
                const ciscoMatch = etab.cisco && etab.cisco.toLowerCase().includes(searchLower);
                
                if (!nomMatch && !communeMatch && !ciscoMatch) {
                    return false;
                }
            }
            
            // Filtre CISCO
            if (ciscoFilter !== 'all' && etab.cisco !== ciscoFilter) {
                return false;
            }
            
            // Filtre secteur
            if (secteurFilter !== 'all' && etab.secteur !== secteurFilter) {
                return false;
            }
            
            return true;
        });
        
        if (filteredData.length === 0) {
            showNotification('Aucun établissement trouvé avec ces critères', 'warning');
            filteredData = currentData;
        } else {
            const searchInfo = searchTerm.trim() !== '' ? ` pour "${searchTerm}"` : '';
            showNotification(`${filteredData.length} établissements filtrés${searchInfo}`, 'success');
        }
        
        updateStats(filteredData);
        updateEtablissementTable(filteredData);
        initializeCharts(filteredData);
        updateMap(filteredData);
    }

    function clearFilters() {
        console.log('🧹 Effacement des filtres...');
        
        document.getElementById('ciscoFilter').value = 'all';
        document.getElementById('secteurFilter').value = 'all';
        
        const currentData = niveauxData[currentLevel] || [];
        
        updateStats(currentData);
        updateEtablissementTable(currentData);
        initializeCharts(currentData);
        updateMap(currentData);
        
        showNotification('Filtres effacés', 'info');
    }

    // ==================== FONCTIONS D'EXPORT ====================

    function exportToCSV() {
        try {
            const currentData = niveauxData[currentLevel] || [];
            
            if (currentData.length === 0) {
                showNotification('Aucune donnée à exporter', 'warning');
                return;
            }
            
            const config = columnConfig[currentLevel];
            const headers = config.csvColumns;
            
            let csvContent = headers.join(';') + '\n';
            
            currentData.forEach(row => {
                const rowData = headers.map(header => {
                    const value = row[header];
                    if (value === null || value === undefined) return '';
                    
                    let strValue = String(value).replace(/"/g, '""');
                    if (strValue.includes(';') || strValue.includes('"') || strValue.includes('\n')) {
                        strValue = '"' + strValue + '"';
                    }
                    return strValue;
                });
                
                csvContent += rowData.join(';') + '\n';
            });
            
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            const url = URL.createObjectURL(blob);
            
            link.setAttribute('href', url);
            link.setAttribute('download', `etablissements_${currentLevel}_${new Date().toISOString().split('T')[0]}.csv`);
            link.style.visibility = 'hidden';
            
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
            showNotification(`Export CSV réussi: ${currentData.length} établissements`, 'success');
            
        } catch (error) {
            console.error('❌ Erreur export CSV:', error);
            showNotification('Erreur lors de l\'export CSV', 'error');
        }
    }

    function exportToExcel() {
        try {
            const currentData = niveauxData[currentLevel] || [];
            
            if (currentData.length === 0) {
                showNotification('Aucune donnée à exporter', 'warning');
                return;
            }
            
            const config = columnConfig[currentLevel];
            const headers = config.csvColumns;
            
            const worksheetData = [
                headers,
                ...currentData.map(row => 
                    headers.map(header => row[header] || '')
                )
            ];
            
            const worksheet = XLSX.utils.aoa_to_sheet(worksheetData);
            const workbook = XLSX.utils.book_new();
            
            XLSX.utils.book_append_sheet(workbook, worksheet, `Établissements ${config.niveauLabel}`);
            
            XLSX.writeFile(workbook, `etablissements_${currentLevel}_${new Date().toISOString().split('T')[0]}.xlsx`);
            
            showNotification(`Export Excel réussi: ${currentData.length} établissements`, 'success');
            
        } catch (error) {
            console.error('❌ Erreur export Excel:', error);
            showNotification('Erreur lors de l\'export Excel. Vérifiez que xlsx.full.min.js est chargé.', 'error');
        }
    }

    // ==================== FONCTIONS MODALES ====================

    function showImportModal() {
        console.log('📤 Affichage modal import');
        
        const modalHTML = `
            <div class="modal fade" id="importModal" tabindex="-1" style="font-size: 0.8rem;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #F6F4EC; border-bottom: 1px solid #9EC967;">
                            <h5 class="modal-title fw-bold" style="color: #fff;">
                                <i class="fas fa-file-import me-2"></i>Importation de données
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Étape 1 : Sélection du niveau -->
                            <div class="mb-4">
                                <label class="form-label fw-bold mb-3" style="color: #3E6E4B;">
                                    <i class="fas fa-graduation-cap me-2"></i>Niveau scolaire
                                </label>
                                <div class="row g-3">
                                    <div class="col-6 col-md-3">
                                        <div class="card text-center level-card" data-level="prescolaire" 
                                            style="border: 2px solid #F6F4EC; cursor: pointer; border-radius: 10px;">
                                            <div class="card-body p-3">
                                                <i class="fas fa-baby fa-2x mb-2" style="color: #3E6E4B;"></i>
                                                <h6 class="mb-0" style="color: #3E6E4B;">Préscolaire</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="card text-center level-card" data-level="primaire" 
                                            style="border: 2px solid #F6F4EC; cursor: pointer; border-radius: 10px;">
                                            <div class="card-body p-3">
                                                <i class="fas fa-pencil-alt fa-2x mb-2" style="color: #3E6E4B;"></i>
                                                <h6 class="mb-0" style="color: #3E6E4B;">Primaire</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="card text-center level-card" data-level="college" 
                                            style="border: 2px solid #F6F4EC; cursor: pointer; border-radius: 10px;">
                                            <div class="card-body p-3">
                                                <i class="fas fa-book fa-2x mb-2" style="color: #3E6E4B;"></i>
                                                <h6 class="mb-0" style="color: #3E6E4B;">Collège</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="card text-center level-card" data-level="lycee" 
                                            style="border: 2px solid #F6F4EC; cursor: pointer; border-radius: 10px;">
                                            <div class="card-body p-3">
                                                <i class="fas fa-university fa-2x mb-2" style="color: #3E6E4B;"></i>
                                                <h6 class="mb-0" style="color: #3E6E4B;">Lycée</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="selectedLevel" value="">
                            </div>
                            
                            <!-- Étape 2 : Zone de dépôt de fichier -->
                            <div class="mb-4">
                                <label class="form-label fw-bold mb-3" style="color: #3E6E4B;">
                                    <i class="fas fa-file me-2"></i>Sélection du fichier
                                </label>
                                <div class="file-drop-zone border rounded p-5 text-center" 
                                    id="fileDropZone"
                                    style="border: 2px dashed #9EC967; background-color: #F6F4EC;">
                                    <i class="fas fa-cloud-upload-alt fa-3x mb-3" style="color: #9EC967;"></i>
                                    <h5 style="color: #3E6E4B;">Glissez-déposez votre fichier ici</h5>
                                    <p class="text-muted mt-2 mb-4">ou</p>
                                    <button class="btn btn-lg" 
                                            onclick="document.getElementById('fileInput').click()"
                                            style="background-color: #3E6E4B; color: #FFFFFF;">
                                        <i class="fas fa-folder-open me-2"></i>Parcourir les fichiers
                                    </button>
                                    <div class="mt-4">
                                        <div class="row g-2">
                                            <div class="col-md-6">
                                                <div class="alert alert-light border" style="border-color: #90FF00;">
                                                    <i class="fas fa-file-csv me-2" style="color: #90FF00;"></i>
                                                    <strong>CSV</strong>
                                                    <div class="small text-muted">.csv</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="alert alert-light border" style="border-color: #90FF00;">
                                                    <i class="fas fa-file-excel me-2" style="color: #90FF00;"></i>
                                                    <strong>Excel</strong>
                                                    <div class="small text-muted">.xlsx, .xls</div>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="small text-muted mt-2">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Taille maximale : 10MB
                                        </p>
                                    </div>
                                </div>
                                <input type="file" id="fileInput" accept=".csv,.xlsx,.xls" style="display: none;">
                            </div>
                            
                            <!-- Étape 3 : Prévisualisation (masquée par défaut) -->
                            <div id="importPreview" style="display: none;">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold mb-0" style="color: #3E6E4B;">
                                        <i class="fas fa-eye me-2"></i>Prévisualisation
                                    </h6>
                                    <div id="fileInfo" class="text-muted small"></div>
                                </div>
                                <div class="table-responsive border rounded" style="max-height: 250px; border-color: #9EC967 !important;">
                                    <table class="table table-sm table-bordered mb-0">
                                        <thead id="previewHeader" style="background-color: #F6F4EC; position: sticky; top: 0;"></thead>
                                        <tbody id="previewBody"></tbody>
                                    </table>
                                </div>
                                <div class="alert alert-light border mt-3" style="border-color: #9EC967; background-color: #F6F4EC;">
                                    <i class="fas fa-info-circle me-2" style="color: #3E6E4B;"></i>
                                    <span class="small" style="color: #3E6E4B;">
                                        Affichage des 10 premières lignes. Vérifiez les données avant l'import.
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="background-color: #F6F4EC; border-top: 1px solid #9EC967;">
                            <div class="w-100 d-flex justify-content-between">
                                <div>
                                    <span id="importStatus" class="small"></span>
                                </div>
                                <div>
                                    <button type="button" class="btn me-2" data-bs-dismiss="modal"
                                            style="background-color: #FFFFFF; color: #3E6E4B; border: 1px solid #3E6E4B;">
                                        Annuler
                                    </button>
                                    <button class="btn" id="confirmImportBtn" onclick="window.dashboard.confirmImport()"
                                            style="background-color: #3E6E4B; color: #FFFFFF; display: none;">
                                        <i class="fas fa-upload me-2"></i>Importer les données
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        const existingModal = document.getElementById('importModal');
        if (existingModal) {
            existingModal.remove();
        }
        
        document.body.insertAdjacentHTML('beforeend', modalHTML);
        
        const importModal = new bootstrap.Modal(document.getElementById('importModal'));
        importModal.show();
        
        // Initialiser les événements
        initializeImportEvents();
    }

    function initializeImportEvents() {
        // Sélection des niveaux
        document.querySelectorAll('.level-card').forEach(card => {
            card.addEventListener('click', function() {
                // Désélectionner toutes les cartes
                document.querySelectorAll('.level-card').forEach(c => {
                    c.style.borderColor = '#F6F4EC';
                    c.style.backgroundColor = '';
                });
                
                // Sélectionner la carte cliquée
                this.style.borderColor = '#3E6E4B';
                this.style.backgroundColor = '#F6F4EC';
                
                // Stocker le niveau sélectionné
                const level = this.getAttribute('data-level');
                document.getElementById('selectedLevel').value = level;
                
                // Mettre à jour le statut
                document.getElementById('importStatus').innerHTML = 
                    `<span style="color: #3E6E4B;"><i class="fas fa-check-circle me-1"></i>Niveau sélectionné : ${level}</span>`;
                
                // Vérifier si un fichier est déjà sélectionné
                if (window.currentFile) {
                    showPreview();
                }
            });
        });
        
        // Zone de dépôt de fichier
        const dropZone = document.getElementById('fileDropZone');
        const fileInput = document.getElementById('fileInput');
        
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.style.borderColor = '#90FF00';
            dropZone.style.backgroundColor = '#FFFFFF';
        });
        
        dropZone.addEventListener('dragleave', () => {
            dropZone.style.borderColor = '#9EC967';
            dropZone.style.backgroundColor = '#F6F4EC';
        });
        
        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.style.borderColor = '#9EC967';
            dropZone.style.backgroundColor = '#F6F4EC';
            
            if (e.dataTransfer.files.length > 0) {
                handleFileSelect(e.dataTransfer.files[0]);
            }
        });
        
        fileInput.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                handleFileSelect(e.target.files[0]);
            }
        });
    }

    function handleFileSelect(file) {
        console.log('📄 Fichier sélectionné:', file);
        
        // Validation
        const validExtensions = ['.csv', '.xlsx', '.xls'];
        const fileExtension = '.' + file.name.split('.').pop().toLowerCase();
        
        if (!validExtensions.includes(fileExtension)) {
            showNotification('Format de fichier non supporté. Utilisez CSV ou Excel.', 'error');
            return;
        }
        
        if (file.size > 10 * 1024 * 1024) {
            showNotification('Le fichier dépasse la taille maximale de 10MB.', 'error');
            return;
        }
        
        // Stocker le fichier globalement
        window.currentFile = file;
        
        // Mettre à jour le statut
        document.getElementById('importStatus').innerHTML = 
            `<span style="color: #3E6E4B;"><i class="fas fa-file me-1"></i>Fichier sélectionné : ${file.name}</span>`;
        
        // Vérifier si un niveau est déjà sélectionné
        const selectedLevel = document.getElementById('selectedLevel').value;
        if (selectedLevel) {
            showPreview();
        } else {
            showNotification('Veuillez d\'abord sélectionner un niveau scolaire.', 'warning');
        }
    }

    function showPreview() {
        if (!window.currentFile) return;
        
        const selectedLevel = document.getElementById('selectedLevel').value;
        if (!selectedLevel) {
            showNotification('Veuillez sélectionner un niveau scolaire.', 'warning');
            return;
        }
        
        // Afficher les informations du fichier
        document.getElementById('fileInfo').innerHTML = `
            <span style="color: #3E6E4B;">
                <i class="fas fa-file me-1"></i>${window.currentFile.name} 
                (${formatBytes(window.currentFile.size)})
            </span>
        `;
        
        // Simuler une prévisualisation (à remplacer par la lecture réelle du fichier)
        const headers = ['École', 'CISCO', 'Commune', 'Secteur', 'Élèves', 'Personnel'];
        const sampleData = [
            ['École A', 'AMBATOLAMPY', 'Commune 1', 'Publique', '150', '10'],
            ['École B', 'ANTSIRABE I', 'Commune 2', 'Privée', '200', '12'],
            ['École C', 'BETAFO', 'Commune 3', 'Publique', '180', '9'],
            ['École D', 'FARATSIHO', 'Commune 4', 'Publique', '220', '15'],
            ['École E', 'MANDOTO', 'Commune 5', 'Privée', '170', '11']
        ];
        
        // Générer l'en-tête du tableau
        const headerHTML = headers.map(header => 
            `<th style="background-color: #3E6E4B; color: #FFFFFF; border-color: #9EC967;">${header}</th>`
        ).join('');
        
        document.getElementById('previewHeader').innerHTML = `<tr>${headerHTML}</tr>`;
        
        // Générer les lignes du tableau
        const bodyHTML = sampleData.map(row => 
            `<tr>${row.map(cell => `<td style="border-color: #9EC967;">${cell}</td>`).join('')}</tr>`
        ).join('');
        
        document.getElementById('previewBody').innerHTML = bodyHTML;
        
        // Afficher la prévisualisation
        document.getElementById('importPreview').style.display = 'block';
        
        // Activer le bouton d'import
        document.getElementById('confirmImportBtn').style.display = 'block';
        
        // Faire défiler jusqu'à la prévisualisation
        document.getElementById('importPreview').scrollIntoView({ behavior: 'smooth' });
    }

    function formatBytes(bytes, decimals = 2) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const dm = decimals < 0 ? 0 : decimals;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
    }

    function confirmImport() {
        const selectedLevel = document.getElementById('selectedLevel').value;
        
        if (!selectedLevel) {
            showNotification('Veuillez sélectionner un niveau scolaire.', 'error');
            return;
        }
        
        if (!window.currentFile) {
            showNotification('Veuillez sélectionner un fichier.', 'error');
            return;
        }
        
        console.log('🚀 Importation pour le niveau:', selectedLevel);
        console.log('📄 Fichier:', window.currentFile.name);
        
        // ICI : AJOUTER LE CODE POUR L'IMPORTATION RÉELLE
        
        // Exemple d'envoi via FormData
        const formData = new FormData();
        formData.append('level', selectedLevel);
        formData.append('file', window.currentFile);
        
        // Simuler un chargement
        document.getElementById('importStatus').innerHTML = 
            `<span style="color: #90FF00;"><i class="fas fa-spinner fa-spin me-1"></i>Importation en cours...</span>`;
        
        // Simuler une requête AJAX (à remplacer par votre code réel)
        setTimeout(() => {
            // Simulation de succès
            document.getElementById('importStatus').innerHTML = 
                `<span style="color: #3E6E4B;"><i class="fas fa-check-circle me-1"></i>Importation réussie !</span>`;
            
            showNotification(`Données ${selectedLevel} importées avec succès !`, 'success');
            
            // Fermer la modal après 2 secondes
            setTimeout(() => {
                bootstrap.Modal.getInstance(document.getElementById('importModal')).hide();
                
                // Recharger les données pour le niveau importé
                if (window.dashboard && window.dashboard.loadData) {
                    window.dashboard.loadData(selectedLevel);
                }
                
                // Réinitialiser
                window.currentFile = null;
            }, 2000);
        }, 1500);
    }

    // Fonction utilitaire pour les notifications
    function showNotification(message, type = 'info') {
        // Votre fonction existante pour les notifications
        console.log(`🔔 ${type.toUpperCase()}: ${message}`);
        
        // Créer une notification Bootstrap toast
        const toastHTML = `
            <div class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex" style="background-color: ${type === 'success' ? '#3E6E4B' : type === 'error' ? '#dc3545' : '#9EC967'}; color: #FFFFFF;">
                    <div class="toast-body">
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        `;
        
        const toastContainer = document.getElementById('toastContainer') || (() => {
            const container = document.createElement('div');
            container.id = 'toastContainer';
            container.className = 'toast-container position-fixed bottom-0 end-0 p-3';
            document.body.appendChild(container);
            return container;
        })();
        
        toastContainer.insertAdjacentHTML('beforeend', toastHTML);
        const toastElement = toastContainer.lastElementChild;
        const toast = new bootstrap.Toast(toastElement);
        toast.show();
        
        // Supprimer le toast après fermeture
        toastElement.addEventListener('hidden.bs.toast', function () {
            this.remove();
        });
    }
    // ==================== FONCTION POUR INITIALISER LE NIVEAU ====================

    async function initializeLevel(level) {
        console.log(`🎯 Initialisation du niveau: ${level}`);
        
        currentLevel = level;
        
        document.querySelectorAll('.level-btn').forEach(btn => {
            btn.classList.remove('active');
            btn.classList.remove('btn-primary', 'btn-success', 'btn-info', 'btn-warning');
            btn.classList.add('btn-outline-secondary');
        });
        
        const currentBtn = document.querySelector(`.level-btn[data-level="${level}"]`);
        if (currentBtn) {
            currentBtn.classList.add('active');
            currentBtn.classList.remove('btn-outline-secondary');
            currentBtn.classList.add('btn-success');
        }
        
        const config = columnConfig[level];
        const niveauLabel = config.niveauLabel;
        
        const pageSubtitle = document.getElementById('pageSubtitle');
        const mapHeader = document.getElementById('mapHeader');
        const tableHeader = document.getElementById('tableHeader');
        
        if (pageSubtitle) pageSubtitle.textContent = `Visualisation des données des établissements ${niveauLabel}`;
        if (mapHeader) mapHeader.textContent = `Carte des Établissements ${niveauLabel}`;
        if (tableHeader) tableHeader.textContent = `Établissements ${niveauLabel}`;
        
        const statsContainer = document.getElementById('statsContainer');
        const tableBody = document.getElementById('etablissementTable');
        
        if (statsContainer) {
            statsContainer.innerHTML = `
                <div class="col-12 text-center py-4">
                    <div class="spinner-border" style="color: #229954;" role="status"></div>
                    <p class="mt-2 text-muted">Chargement des données ${niveauLabel}...</p>
                </div>
            `;
        }
        
        if (tableBody) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center py-4">
                        <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                        Chargement des établissements ${niveauLabel}...
                    </td>
                </tr>
            `;
        }
        
        try {
            const data = await loadCSVData(level);
            
            if (data.length === 0) {
                showNotification(`Aucune donnée disponible pour le niveau ${niveauLabel}`, 'warning');
                
                if (tableBody) {
                    tableBody.innerHTML = `
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-warning mb-3">
                                    <i class="fas fa-exclamation-triangle fa-3x"></i>
                                </div>
                                <h5 class="text-muted">Aucune donnée disponible</h5>
                                <p class="text-muted small">
                                    Les données pour ce niveau n'ont pas pu être chargées.
                                </p>
                            </td>
                        </tr>
                    `;
                }
                
                updateStats([]);
                initializeCharts([]);
                updateMap([]);
                
                return;
            }
            
            filteredData = data;
            
            updateStats(data);
            updateEtablissementTable(data);
            initializeCharts(data);
            updateMap(data);
            
            console.log(`✅ Niveau ${level} initialisé avec ${data.length} établissements`);
            showNotification(`${data.length} établissements ${niveauLabel} chargés`, 'success');
            
        } catch (error) {
            console.error(`❌ Erreur lors de l'initialisation du niveau ${level}:`, error);
            showNotification(`Erreur chargement ${niveauLabel}: ${error.message}`, 'error');
        }
    }

    // ==================== FONCTIONS PRINCIPALES ====================

    async function loadAllData() {
        console.log('🚀 DÉMARRAGE DU CHARGEMENT DES DONNÉES...');
        
        try {
            if (!map) {
                map = initMap();
                await new Promise(resolve => setTimeout(resolve, 300));
            }
            
            await initializeLevel(currentLevel);
            
            const niveaux = ['prescolaire', 'primaire', 'college', 'lycee'];
            
            for (const niveau of niveaux) {
                if (niveau !== currentLevel) {
                    setTimeout(async () => {
                        try {
                            const data = await loadCSVData(niveau);
                            if (data.length > 0) {
                                console.log(`✅ Données ${niveau} chargées en arrière-plan: ${data.length} établissements`);
                            }
                        } catch (error) {
                            console.warn(`⚠️ Erreur chargement ${niveau}:`, error.message);
                        }
                    }, 100);
                }
            }
            
            console.log('🎉 DONNÉES CHARGÉES AVEC SUCCÈS!');
            isInitialized = true;
            
        } catch (error) {
            console.error('💥 ERREUR CRITIQUE:', error);
            showNotification('Erreur lors du chargement des données', 'error');
        }
    }

    function setupArchiveDropdown() {
        const dropdown = document.getElementById('archiveDropdown');
        if (!dropdown) return;
        
        const archives = [
            { year: '2024-2025', active: true },
            { year: '2023-2024', active: false },
            { year: '2022-2023', active: false }
        ];
        
        let html = '';
        archives.forEach(archive => {
            html += `
                <li>
                    <a class="dropdown-item ${archive.active ? 'active' : ''}" href="#">
                        ${archive.year}
                        ${archive.active ? '<span class="badge bg-primary ms-2">Actuel</span>' : ''}
                    </a>
                </li>
            `;
        });
        
        dropdown.innerHTML = html;
    }

    function clearCacheAndReload() {
        if (confirm('Voulez-vous vraiment vider le cache et recharger les données ?')) {
            const cleared = clearLocalStorage();
            setTimeout(() => {
                location.reload();
            }, 500);
        }
    }

    function init() {
        console.log('🏁 Dashboard initializing...');
        
        if (isInitialized) {
            console.log('⚠️ Dashboard déjà initialisé');
            return;
        }
        
        if (!map) {
            map = initMap();
        }
        
        document.querySelectorAll('.level-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const level = e.currentTarget.dataset.level;
                initializeLevel(level);
            });
        });
        
        setupArchiveDropdown();
        
        loadAllData();
        
        console.log('✅ Dashboard initialisé avec succès');
    }

    // ==================== API PUBLIQUE ====================

    return {
        // Initialisation
        init,
        initializeLevel,
        loadAllData,
        
        // Affichage
        showDetails,
        updateStats,
        updateEtablissementTable,
        updateMap,
        showOnMap,
        getClassesInfo,
        
        // Filtres
        applyFilters,
        clearFilters,
        applySearch,
        
        // Export
        exportToCSV,
        exportToExcel,
        exportEtablissementData,
        
        // Import
        handleFileImport,
        showImportModal,
        confirmImport,
        
        // Itinéraire
        showItineraireModal,
        drawDirectLine,
        calculateRoute,
        clearItineraire,
        getCurrentLocation,
        calculateItineraireAdvanced,
        showSimpleItineraireSummary,
        
        // Gestion données
        clearLocalStorage,
        clearCacheAndReload,
        setupArchiveDropdown,
        
        // Fonctions auxiliaires itinéraire (exposées pour usage global)
        updateStartEtablissementInfo,
        updateEndEtablissementInfo,
        searchEtablissements,
        filterEndPoints,
        showAllEndPoints,
        clearSearch,
        formatDetailValue,
        
        // Getters
        get niveauxData() { return {...niveauxData}; },
        get currentLevel() { return currentLevel; },
        get map() { return map; },
        get currentUserLocation() { return currentUserLocation; },
        get selectedStartEtablissement() { return selectedStartEtablissement; },
        get selectedEndEtablissement() { return selectedEndEtablissement; }
    };
})();

// ==================== FONCTIONS GLOBALES ====================

// Variables globales pour l'import
let currentImportFile = null;
let currentImportNiveau = 'prescolaire';

// Fonction pour gérer la sélection de fichier
window.handleFileSelect = function(file) {
    currentImportFile = file;
    currentImportNiveau = document.getElementById('importNiveauSelect')?.value || 'prescolaire';
    
    // Afficher les infos du fichier
    const fileInfo = document.getElementById('fileInfo');
    if (fileInfo) {
        fileInfo.innerHTML = `
            <i class="fas fa-file me-1"></i>
            <strong>${file.name}</strong> (${(file.size / 1024 / 1024).toFixed(2)} MB)
        `;
    }
    
    // Prévisualisation pour CSV
    if (file.name.endsWith('.csv')) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const text = e.target.result;
            const lines = text.split('\n').slice(0, 6);
            
            let html = '';
            lines.forEach((line, index) => {
                const cells = line.split(';');
                if (index === 0) {
                    const headers = cells.map(cell => `<th>${cell}</th>`).join('');
                    const previewHeader = document.getElementById('previewHeader');
                    if (previewHeader) {
                        previewHeader.innerHTML = `<tr>${headers}</tr>`;
                    }
                } else {
                    const row = cells.map(cell => `<td>${cell}</td>`).join('');
                    html += `<tr>${row}</tr>`;
                }
            });
            
            const previewBody = document.getElementById('previewBody');
            if (previewBody) {
                previewBody.innerHTML = html;
            }
            
            const filePreview = document.getElementById('filePreview');
            if (filePreview) {
                filePreview.style.display = 'block';
            }
        };
        reader.readAsText(file);
    } else {
        const previewHeader = document.getElementById('previewHeader');
        const previewBody = document.getElementById('previewBody');
        if (previewHeader) previewHeader.innerHTML = '';
        if (previewBody) previewBody.innerHTML = '';
        
        const filePreview = document.getElementById('filePreview');
        if (filePreview) {
            filePreview.style.display = 'block';
        }
    }
};

// Fonction pour confirmer l'import
window.confirmImport = function() {
    if (!currentImportFile || !window.dashboard) {
        alert('Veuillez sélectionner un fichier');
        return;
    }
    
    window.dashboard.handleFileImport(currentImportFile, currentImportNiveau)
        .then(success => {
            if (success) {
                const modal = bootstrap.Modal.getInstance(document.getElementById('importModal'));
                if (modal) modal.hide();
            }
        });
};

// Fonctions pour les actions rapides d'itinéraire
window.setAsStartPoint = function(etablissement) {
    if (!window.dashboard) return;
    
    window.dashboard.selectedStartEtablissement = etablissement;
    showNotification(`${etablissement.nom_etab} défini comme point de départ`, 'success');
    
    // Ouvrir automatiquement la modal d'itinéraire
    window.dashboard.showItineraireModal();
    
    // Sélectionner l'option "établissement" dans la modal
    setTimeout(() => {
        const etablissementRadio = document.getElementById('etablissementRadio');
        if (etablissementRadio) {
            etablissementRadio.checked = true;
            etablissementRadio.dispatchEvent(new Event('change'));
            
            // Trouver l'index de l'établissement dans la liste
            const currentData = window.dashboard.niveauxData[window.dashboard.currentLevel] || [];
            const index = currentData.findIndex(e => e.code_etab === etablissement.code_etab);
            
            if (index !== -1) {
                const startSelect = document.getElementById('startPointSelect');
                if (startSelect) {
                    startSelect.value = index;
                    window.dashboard.updateStartEtablissementInfo();
                }
            }
        }
    }, 500);
};

window.setAsEndPoint = function(etablissement) {
    if (!window.dashboard) return;
    
    window.dashboard.selectedEndEtablissement = etablissement;
    showNotification(`${etablissement.nom_etab} défini comme point d'arrivée`, 'success');
    
    // Ouvrir automatiquement la modal d'itinéraire
    window.dashboard.showItineraireModal();
    
    // Trouver l'index de l'établissement dans la liste
    setTimeout(() => {
        const currentData = window.dashboard.niveauxData[window.dashboard.currentLevel] || [];
        const index = currentData.findIndex(e => e.code_etab === etablissement.code_etab);
        
        if (index !== -1) {
            const endSelect = document.getElementById('endPointSelect');
            if (endSelect) {
                endSelect.value = index;
                window.dashboard.updateEndEtablissementInfo();
            }
        }
    }, 500);
};

// Fonction pour afficher plus de détails sur l'itinéraire
window.showItineraireDetails = function() {
    const modalHTML = `
        <div class="modal fade" id="itineraireDetailsModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-info-circle me-2"></i>Détails de l'itinéraire
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <i class="fas fa-lightbulb me-2"></i>
                            Cette fonctionnalité affichera des informations détaillées sur l'itinéraire
                            dans une future version de l'application.
                        </div>
                        <div class="mt-3">
                            <h6>Fonctionnalités prévues :</h6>
                            <ul class="small">
                                <li>Instructions détaillées étape par étape</li>
                                <li>Points d'intérêt le long du trajet</li>
                                <li>Estimation des coûts de transport</li>
                                <li>Téléchargement de l'itinéraire en PDF</li>
                                <li>Partage de l'itinéraire</li>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    const existingModal = document.getElementById('itineraireDetailsModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    document.body.insertAdjacentHTML('beforeend', modalHTML);
    
    const modal = new bootstrap.Modal(document.getElementById('itineraireDetailsModal'));
    modal.show();
};

// Fonctions utilitaires globales
window.clearCache = function() {
    if (confirm('Voulez-vous vraiment vider le cache et recharger les données ?')) {
        if (window.dashboard && window.dashboard.clearLocalStorage) {
            window.dashboard.clearLocalStorage();
        } else {
            localStorage.clear();
        }
        setTimeout(() => location.reload(), 500);
    }
};

window.refreshData = function() {
    if (window.dashboard) {
        window.dashboard.initializeLevel(window.dashboard.currentLevel);
    } else {
        location.reload();
    }
};

window.logout = function() {
    if (confirm('Êtes-vous sûr de vouloir vous déconnecter ?')) {
        // Récupérer le token CSRF depuis la meta tag
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        fetch('/logout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            credentials: 'same-origin'
        })
        .then(response => {
            if (response.ok) {
                // Supprimer le cache et forcer la redirection vers la page de connexion
                window.location.replace('/login');
            } else {
                return response.json().then(data => {
                    throw new Error(data.message || 'Erreur lors de la déconnexion');
                });
            }
        })
        .catch(error => {
            console.error('Erreur lors de la déconnexion:', error);
            // Rediriger quand même vers la page de connexion en cas d'erreur
            window.location.href = '/login';
        });
    }
};

window.logoutSuperAdmin = function() {
    if (confirm('Êtes-vous sûr de vouloir vous déconnecter ?')) {
        // Récupérer le token CSRF
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // URL correcte pour le logout super admin
        fetch('/super-admin/logout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            credentials: 'same-origin'
        })
        .then(response => {
            if (response.ok) {
                // Redirection vers la page de login super admin
                window.location.href = '/super-admin/login';
            } else if (response.status === 401) {
                // Si déjà déconnecté ou session expirée
                window.location.href = '/super-admin/login';
            } else {
                return response.json().then(data => {
                    throw new Error(data.message || 'Erreur lors de la déconnexion');
                });
            }
        })
        .catch(error => {
            console.error('Erreur lors de la déconnexion:', error);
            // Fallback: rediriger vers la page de login
            window.location.href = '/super-admin/login';
        });
    }
};

// Fonction pour les popups
window.showDashboardDetails = function(etablissement) {
    if (window.dashboard && typeof window.dashboard.showDetails === 'function') {
        window.dashboard.showDetails(etablissement);
    } else {
        console.error('Dashboard non disponible');
    }
};

// Initialiser le dashboard quand le DOM est chargé
document.addEventListener('DOMContentLoaded', function() {
    console.log('📋 Dashboard - DOM chargé');
    
    setTimeout(() => {
        try {
            if (window.dashboard && typeof window.dashboard.init === 'function') {
                window.dashboard.init();
            } else {
                console.error('❌ Dashboard non initialisé correctement');
                showNotification('Erreur d\'initialisation du dashboard', 'error');
            }
        } catch (error) {
            console.error('❌ Erreur lors de l\'initialisation:', error);
            showNotification('Erreur lors du chargement de l\'application', 'error');
        }
    }, 100);
});

// Gestion des erreurs
window.addEventListener('error', function(event) {
    console.error('💥 Erreur non capturée:', event.error);
});

window.addEventListener('unhandledrejection', function(event) {
    console.error('💥 Promesse rejetée non gérée:', event.reason);
});

// Styles pour les animations
const style = document.createElement('style');
style.textContent = `
    @keyframes pulse {
        0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(231, 76, 60, 0.7); }
        70% { transform: scale(1.1); box-shadow: 0 0 0 10px rgba(231, 76, 60, 0); }
        100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(231, 76, 60, 0); }
    }
    
    .highlight-marker {
        animation: pulse 2s infinite;
    }
    
    @keyframes bounce {
        from { transform: translateY(0); }
        to { transform: translateY(-10px); }
    }
    
    .current-location-marker {
        animation: pulse 2s infinite;
    }
    
    .route-marker-start {
        animation: bounce 1s infinite alternate;
    }
    
    .route-marker-end {
        animation: bounce 1s infinite alternate-reverse;
    }
`;
document.head.appendChild(style);