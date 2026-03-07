import React from 'react';

const Sidebar = ({ isOpen, onClose }) => {
    if (!isOpen) return null;
    return (
        <aside className="sidebar">
            <button onClick={onClose}>❌ Fermer</button>
            <p>Menu latéral</p>
        </aside>
    );
};

export default Sidebar;