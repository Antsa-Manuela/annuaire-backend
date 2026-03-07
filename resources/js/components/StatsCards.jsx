// ressources/js/components/StatsCards.js
import React from 'react';

const StatsCards = ({ stats, popularPages }) => {
    return (
        <div className="stats-section">
            {/* Cartes de statistiques */}
            <div className="stats-cards-grid">
                <div className="stat-card total-visits">
                    <div className="stat-icon">📊</div>
                    <div className="stat-content">
                        <h3>Total des Visites</h3>
                        <p className="stat-number">{stats.total_visits}</p>
                        <p className="stat-trend">📈 Activité globale</p>
                    </div>
                </div>

                <div className="stat-card total-admins">
                    <div className="stat-icon">👥</div>
                    <div className="stat-content">
                        <h3>Administrateurs</h3>
                        <p className="stat-number">{stats.total_admins}</p>
                        <p className="stat-trend">🟢 Tous actifs</p>
                    </div>
                </div>
            </div>

            {/* Pages populaires */}
            <div className="popular-pages-card">
                <h3 className="section-title">🔥 Pages Populaires</h3>
                <div className="pages-ranking">
                    {popularPages && popularPages.length > 0 ? (
                        popularPages.map((page, index) => (
                            <div key={index} className="page-rank-item">
                                <div className="rank-badge">#{index + 1}</div>
                                <div className="page-info">
                                    <div className="page-name">{page.page_name}</div>
                                    <div className="page-visits">{page.visit_count} visites</div>
                                </div>
                            </div>
                        ))
                    ) : (
                        <div className="empty-pages">
                            <p>Aucune donnée disponible</p>
                        </div>
                    )}
                </div>
            </div>
        </div>
    );
};

export default StatsCards;