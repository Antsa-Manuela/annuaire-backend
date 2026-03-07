import React from 'react';

const Header = ({ onMenuToggle, sidebarOpen }) => {
    return (
        <header className="header">
            <button onClick={onMenuToggle}>
                {sidebarOpen ? '🔽 Fermer' : '📂 Ouvrir'}
            </button>
            <h1>Header</h1>
        </header>
    );
};

export default Header;