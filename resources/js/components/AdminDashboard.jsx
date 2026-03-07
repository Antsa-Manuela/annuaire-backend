// ressources/js/components/AdminDashboard.js
import React, { useState, useEffect } from 'react';
import axios from 'axios';
import AdminCard from './AdminCard.jsx'; // './AdminCard.jsx' est surligné en rouge, pourquoi?
import ActivityList from './ActivityList.jsx';
import Filters from './Filters.jsx';
import StatsCards from './StatsCards.jsx';
import ExcelExport from './ExcelExport.jsx';
import Header from './layout/Header.jsx';
import Sidebar from './layout/Sidebar.jsx';
import VisitChart from './charts/VisitChart.jsx';
import ActivityChart from './charts/ActivityChart.jsx';

const AdminDashboard = () => {
    const [dashboardData, setDashboardData] = useState(null);
    const [activities, setActivities] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const [sidebarOpen, setSidebarOpen] = useState(false);

    useEffect(() => {
        loadDashboardData();
    }, []);

    const loadDashboardData = async () => {
        try {
            setLoading(true);
            const [dashboardResponse, activitiesResponse] = await Promise.all([
                axios.get('/api/dashboard/data'),
                axios.get('/api/admin/activities')
            ]);
            
            setDashboardData(dashboardResponse.data);
            setActivities(activitiesResponse.data);
            setError(null);
        } catch (err) {
            setError('Erreur lors du chargement des données');
            console.error('Erreur:', err);
        } finally {
            setLoading(false);
        }
    };

    const handleFiltersChange = async (filters) => {
        try {
            const response = await axios.get('/api/admin/activities', {
                params: filters
            });
            setActivities(response.data);
        } catch (err) {
            setError('Erreur lors du filtrage');
            console.error('Erreur filtrage:', err);
        }
    };

    const refreshData = () => {
        loadDashboardData();
    };

    if (loading) {
        return (
            <div className="loading">
                <div>🔄 Chargement du tableau de bord...</div>
            </div>
        );
    }

    if (error) {
        return (
            <div className="error-message">
                {error}
                <button onClick={loadDashboardData} style={{marginLeft: '10px'}}>
                    Réessayer
                </button>
            </div>
        );
    }

    return (
        <div className="admin-dashboard">
            <Header 
                onMenuToggle={() => setSidebarOpen(!sidebarOpen)}
                sidebarOpen={sidebarOpen}
            />
            
            <div className="dashboard-container">
                <Sidebar 
                    isOpen={sidebarOpen}
                    onClose={() => setSidebarOpen(false)}
                />
                
                <div className="dashboard-content">
                    <div className="content-header">
                        <div className="header-info">
                            <h1>Tableau de Bord Administrateur</h1>
                            <p>Gestion des activités et statistiques</p>
                        </div>
                        <div className="header-actions">
                            <ExcelExport 
                                activities={activities} 
                                dashboardData={dashboardData}
                            />
                            <button onClick={refreshData} className="btn-refresh">
                                🔄 Actualiser
                            </button>
                        </div>
                    </div>

                    <div className="dashboard-grid">
                        {/* Colonne principale */}
                        <div className="main-column">
                            {/* Profils des admins */}
                            <AdminCard admins={dashboardData.admins} />

                            {/* Graphiques */}
                            <div className="charts-grid">
                                <VisitChart activities={activities} />
                                <ActivityChart activities={activities} />
                            </div>

                            {/* Liste des activités */}
                            <ActivityList 
                                activities={activities}
                                title="Activités Récentes"
                                onRefresh={refreshData}
                            />
                        </div>

                        {/* Sidebar */}
                        <div className="sidebar-column">
                            {/* Statistiques */}
                            <StatsCards 
                                stats={dashboardData.stats}
                                popularPages={dashboardData.popular_pages}
                            />

                            {/* Filtres */}
                            <Filters 
                                admins={dashboardData.admins}
                                onFiltersChange={handleFiltersChange}
                                onRefresh={refreshData}
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default AdminDashboard;