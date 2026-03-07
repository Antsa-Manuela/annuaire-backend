// ressources/js/components/ExcelExport.js
import React, { useState } from 'react';
import axios from 'axios';

const ExcelExport = ({ activities, dashboardData }) => {
    const [exporting, setExporting] = useState(false);

    const exportToExcel = async () => {
        setExporting(true);
        try {
            const response = await axios.get('/api/excel/export/activities', {
                responseType: 'blob'
            });
            
            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement('a');
            link.href = url;
            const date = new Date().toString().split('T')[0];
            link.setAttribute('download', `activites_admins_${date}.xlsx`);
            document.body.appendChild(link);
            link.click();
            link.remove();
            
            // Libérer l'URL
            setTimeout(() => window.URL.revokeObjectURL(url), 100);
            
            // Notification de succès
            alert('✅ Export Excel réussi !');
        } catch (error) {
            alert('❌ Erreur lors de l\'exportation');
            console.error('Erreur export:', error);
        } finally {
            setExporting(false);
        }
    };

    return (
        <button 
            onClick={exportToExcel} 
            className="btn-export"
            disabled={exporting}
            title="Exporter les données vers Excel"
        >
            {exporting ? '⏳ Export...' : '📊 Exporter Excel'}
        </button>
    );
};

export default ExcelExport;