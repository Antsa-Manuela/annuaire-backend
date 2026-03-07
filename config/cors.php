<?php
// config/cors.php
return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'http://localhost:5173', // dev
        'https://annuaire-de-vakinankaratra.web.app' // prod
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],
    'supports_credentials' => true, // nécessaire pour les cookies Sanctum

    'exposed_headers' => [],

    'max_age' => 0,

];
