<?php

return [

    'paths' => [
        'api/*',       // våre API-endepunkter
        'sanctum/csrf-cookie', // ufarlig å ha med
    ],

    // Les tillatte origins fra .env (komma-separert)
    'allowed_origins' => array_filter(array_map('trim', explode(',', env('FRONTEND_ORIGINS', '')))),

    // Behold default for patterns
    'allowed_origins_patterns' => [],

    // Tillatte metoder
    'allowed_methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],

    // Tillatte headere (browser sender ofte disse)
    'allowed_headers' => ['Content-Type', 'Accept', 'Authorization', 'X-Requested-With'],

    // Om respons-headere som UI bør lese
    'exposed_headers' => [
        'X-RateLimit-Limit',
        'X-RateLimit-Remaining',
        'Retry-After',
    ],

    'max_age' => 600,

    // Bruker vi ikke cookie-basert auth → false
    'supports_credentials' => false,
];
