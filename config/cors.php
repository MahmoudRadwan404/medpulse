<?php

return [
    /*
     * Paths that should have CORS headers applied
     */
    'paths' => ['api/*','*'],

    /*
     * Allowed HTTP methods
     */
    'allowed_methods' => ['*'],

    /*
     * Allowed origins - specify your frontend URL(s)
     * Use ['*'] for development, but specify exact domains in production
     */
    'allowed_origins' => explode(',', env('CORS_ALLOWED_ORIGINS', '*')), // or ['http://localhost:3000', 'https://yourdomain.com']

    'allowed_origins_patterns' => [],

    /*
     * Allowed headers - important for JWT
     */
    'allowed_headers' => ['*'],

    /*
     * Headers to expose to the browser
     */
    'exposed_headers' => ['Authorization'],

    /*
     * Max age for preflight request cache
     */
    'max_age' => 0,

    /*
     * Allow credentials (cookies, authorization headers, etc.)
     * Set to true if you're sending JWT in Authorization header
     */
    'supports_credentials' => true,
];