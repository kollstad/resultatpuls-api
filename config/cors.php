<?php

return [

    // Hvilke paths som CORS-beskyttes
    'paths' => [
        'api/*',
        'sanctum/csrf-cookie',
    ],

    // Eksplisitte origins fra .env (komma-separert)
    // Eksempler settes i steg B under.
    'allowed_origins' => array_filter(array_map('trim', explode(',', env('FRONTEND_ORIGINS', '')))),

    // Tillat alle Vercel-subdomener (preview + prod)
    'allowed_origins_patterns' => [
        '#^https://.*\.vercel\.app$#',
    ],

    // Vær litt raus i starten – enklere feilsøking
    'allowed_methods' => ['*'],
    'allowed_headers' => ['*'],

    // Header(e) UI kan lese (valgfritt)
    'exposed_headers' => [
        'X-RateLimit-Limit',
        'X-RateLimit-Remaining',
        'Retry-After',
    ],

    'max_age' => 600,

    // Ingen cookie-basert auth på tvers av domener → false
    'supports_credentials' => false,
];
