/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// ressources/js/bootstrap.js

// Configuration Axios
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.withCredentials = true;

// Intercepteur pour les requêtes
axios.interceptors.request.use(
    config => {
        // Ajouter un token CSRF si disponible
        const token = document.querySelector('meta[name="csrf-token"]');
        if (token) {
            config.headers['X-CSRF-TOKEN'] = token.getAttribute('content');
        }
        return config;
    },
    error => {
        return Promise.reject(error);
    }
);

// Intercepteur pour les réponses
axios.interceptors.response.use(
    response => response,
    error => {
        if (error.response?.status === 401) {
            // Rediriger vers la page de login si non authentifié
            window.location.href = '/login';
        }
        return Promise.reject(error);
    }
);