// ressources/js/components/ActivityList.js
import React from 'react';

const ActivityList = ({ activities, title = "Activités", onRefresh }) => {
    const getRoleBadge = (role) => {
        return role === 'super_admin' ? 'Super Admin' : 'Admin';
    };

    const getRoleClass = (role) => {
        return role === 'super_admin' ? 'super-admin' : 'admin';
    };

    const formatTimeSpent = (seconds) => {
        if (seconds < 60) return `${seconds}s`;
        const minutes = Math.floor(seconds / 60);
        const remainingSeconds = seconds % 60;
        return `${minutes}m ${remainingSeconds}s`;
    };

    if (!activities || activities.length === 0) {
        return (
            <div className="activities-section">
                <div className="activities-header">
                    <h2 className="activities-title">{title}</h2>
                    <button onClick={onRefresh} className="btn-refresh">
                        🔄 Actualiser
                    </button>
                </div>
                <div className="empty-state">
                    <div className="icon">📊</div>
                    <p>Aucune activité trouvée</p>
                    <p className="small">Les activités apparaîtront ici lorsqu'elles seront disponibles</p>
                </div>
            </div>
        );
    }

    return (
        <div className="activities-section">
            <div className="activities-header">
                <h2 className="activities-title">{title}</h2>
                <div className="activities-actions">
                    <span className="activities-count">{activities.length} activités</span>
                    <button onClick={onRefresh} className="btn-refresh">
                        🔄 Actualiser
                    </button>
                </div>
            </div>
            
            <div className="activities-list">
                {activities.map(activity => (
                    <div 
                        key={activity.id} 
                        className={`activity-item ${getRoleClass(activity.admin.role)}`}
                        title={`Cliquer pour voir les détails de ${activity.page_name}`}
                    >
                        <div className="activity-main">
                            <div className="activity-admin">
                                <span className="admin-name">
                                    {activity.admin.role === 'super_admin' ? '👑' : '⚙️'} 
                                    {activity.admin.name}
                                </span>
                                <span className={`admin-role-badge ${getRoleClass(activity.admin.role)}`}>
                                    {getRoleBadge(activity.admin.role)}
                                </span>
                            </div>
                            <div className="activity-page">
                                {activity.page_name}
                            </div>
                            <div className="activity-url">
                                {activity.page_url}
                            </div>
                        </div>
                        <div className="activity-details">
                            <span className="activity-time">
                                ⏱️ {formatTimeSpent(activity.time_spent)}
                            </span>
                            <span className="activity-date">
                                📅 {new Date(activity.visited_at).toLocaleString('fr-FR')}
                            </span>
                        </div>
                    </div>
                ))}
            </div>
        </div>
    );
};

export default ActivityList;