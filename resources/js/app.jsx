import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
// ressources/js/app.js
import React from 'react';
import { createRoot } from 'react-dom/client';
import AdminDashboard from './components/AdminDashboard.jsx';

// Import CSS
import '../css/app.css';
import '../css/admin-dashboard.css';
import '../css/components/admin-card.css';
import '../css/components/activity-list.css';
import '../css/components/filters.css';

function App() {
    return <AdminDashboard />;
}

// Rendu dans le DOM
const container = document.getElementById('app');
if (container) {
    const root = createRoot(container);
    root.render(<App />);
}