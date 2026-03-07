// ressources/js/components/AdminCard.js
import React from 'react';

const AdminCard = ({ admins }) => {
    const { super_admin, admin } = admins;

    const getStatusInfo = (lastLogin) => {
        const lastLoginDate = new Date(lastLogin);
        const now = new Date();
        const diffHours = (now - lastLoginDate) / (1000 * 60 * 60);
        
        if (diffHours < 1) return { status: 'En ligne', class: 'status-active', icon: '🟢' };
        if (diffHours < 24) return { status: 'Récent', class: 'status-active', icon: '🟡' };
        return { status: 'Hors ligne', class: 'status-inactive', icon: '🔴' };
    };

    return (
        <div className="admin-profiles">
            <h2 className="section-title">👥 Profils Administrateurs</h2>
            <div className="profiles-grid">
                {/* Super Admin */}
                {super_admin && (
                    <div className="admin-card super-admin">
                        <div className="admin-badge">Super Admin</div>
                        <div className="admin-avatar">👑</div>
                        <h3 className="admin-name">{super_admin.name}</h3>
                        <div className="admin-role">Administrateur Principal</div>
                        <div className="admin-stats">
                            <div className="admin-stat">
                                <span className="stat-label">Visites totales:</span>
                                <span className="stat-value highlight">{super_admin.visits}</span>
                            </div>
                            <div className="admin-stat">
                                <span className="stat-label">Dernière connexion:</span>
                                <span className="stat-value">
                                    {new Date(super_admin.last_login).toLocaleDateString('fr-FR', {
                                        year: 'numeric',
                                        month: 'long',
                                        day: 'numeric',
                                        hour: '2-digit',
                                        minute: '2-digit'
                                    })}
                                </span>
                            </div>
                            <div className="admin-stat">
                                <span className="stat-label">Statut:</span>
                                <span className={`admin-status ${getStatusInfo(super_admin.last_login).class}`}>
                                    {getStatusInfo(super_admin.last_login).icon}
                                    {getStatusInfo(super_admin.last_login).status}
                                </span>
                            </div>
                        </div>
                    </div>
                )}

                {/* Admin */}
                {admin && (
                    <div className="admin-card admin">
                        <div className="admin-badge">Admin</div>
                        <div className="admin-avatar">⚙️</div>
                        <h3 className="admin-name">{admin.name}</h3>
                        <div className="admin-role">Administrateur</div>
                        <div className="admin-stats">
                            <div className="admin-stat">
                                <span className="stat-label">Visites totales:</span>
                                <span className="stat-value highlight">{admin.visits}</span>
                            </div>
                            <div className="admin-stat">
                                <span className="stat-label">Dernière connexion:</span>
                                <span className="stat-value">
                                    {new Date(admin.last_login).toLocaleDateString('fr-FR', {
                                        year: 'numeric',
                                        month: 'long',
                                        day: 'numeric',
                                        hour: '2-digit',
                                        minute: '2-digit'
                                    })}
                                </span>
                            </div>
                            <div className="admin-stat">
                                <span className="stat-label">Statut:</span>
                                <span className={`admin-status ${getStatusInfo(admin.last_login).class}`}>
                                    {getStatusInfo(admin.last_login).icon}
                                    {getStatusInfo(admin.last_login).status}
                                </span>
                            </div>
                        </div>
                    </div>
                )}
            </div>
        </div>
    );
};

export default AdminCard;