// ressources/js/components/Filters.js
import React, { useState } from 'react';
import axios from 'axios';

const Filters = ({ admins, onFiltersChange, onRefresh }) => {
    const [filters, setFilters] = useState({
        admin_id: 'all',
        date_from: '',
        date_to: ''
    });
    const [importFile, setImportFile] = useState(null);
    const [importing, setImporting] = useState(false);

    const handleFilterChange = (key, value) => {
        const newFilters = { ...filters, [key]: value };
        setFilters(newFilters);
    };

    const applyFilters = () => {
        onFiltersChange(filters);
    };

    const clearFilters = () => {
        const clearedFilters = {
            admin_id: 'all',
            date_from: '',
            date_to: ''
        };
        setFilters(clearedFilters);
        onFiltersChange(clearedFilters);
    };

    const handleImport = async () => {
        if (!importFile) return;

        setImporting(true);
        const formData = new FormData();
        formData.append('file', importFile);

        try {
            await axios.post('/api/excel/import/data', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            });
            alert('✅ Fichier importé avec succès !');
            setImportFile(null);
            onRefresh();
        } catch (error) {
            alert('❌ Erreur lors de l\'importation');
            console.error('Erreur import:', error);
        } finally {
            setImporting(false);
        }
    };

    const hasActiveFilters = filters.admin_id !== 'all' || filters.date_from || filters.date_to;

    return (
        <div className="filters-section">
            <div className="filters-header">
                <h3 className="filters-title">🔧 Filtres et Actions</h3>
                <button 
                    onClick={clearFilters} 
                    className="clear-filters"
                    disabled={!hasActiveFilters}
                >
                    ❌ Effacer
                </button>
            </div>

            <div className="filters-grid">
                <div className="filter-group">
                    <label className="filter-label">👤 Administrateur</label>
                    <select 
                        className="filter-select"
                        value={filters.admin_id}
                        onChange={(e) => handleFilterChange('admin_id', e.target.value)}
                    >
                        <option value="all">Tous les admins</option>
                        {admins.super_admin && (
                            <option value={admins.super_admin.id}>
                                {admins.super_admin.name} (Super Admin)
                            </option>
                        )}
                        {admins.admin && (
                            <option value={admins.admin.id}>
                                {admins.admin.name} (Admin)
                            </option>
                        )}
                    </select>
                </div>

                <div className="filter-group">
                    <label className="filter-label">📅 Date de début</label>
                    <input 
                        type="date"
                        className="filter-date"
                        value={filters.date_from}
                        onChange={(e) => handleFilterChange('date_from', e.target.value)}
                    />
                </div>

                <div className="filter-group">
                    <label className="filter-label">📅 Date de fin</label>
                    <input 
                        type="date"
                        className="filter-date"
                        value={filters.date_to}
                        onChange={(e) => handleFilterChange('date_to', e.target.value)}
                    />
                </div>
            </div>

            <div className="filter-actions">
                <button onClick={applyFilters} className="btn-apply">
                    🔍 Appliquer les filtres
                </button>
            </div>

            <div className="import-section">
                <h4 className="import-title">📤 Importation Excel</h4>
                <div className="file-input-wrapper">
                    <input 
                        type="file"
                        className="file-input"
                        accept=".xlsx,.xls"
                        onChange={(e) => setImportFile(e.target.files[0])}
                    />
                    <button 
                        onClick={handleImport} 
                        className="btn-import"
                        disabled={!importFile || importing}
                    >
                        {importing ? '⏳ Import...' : '📥 Importer'}
                    </button>
                </div>
                <div className="import-info">
                    💡 Formats supportés: .xlsx, .xls
                </div>
            </div>
        </div>
    );
};

export default Filters;