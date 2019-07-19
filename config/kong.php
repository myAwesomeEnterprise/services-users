<?php

return [

    'scheme' => env('KONG_SCHEME', 'http'),

    'host' => env('KONG_HOST', 'kong'),

    'port' => env('KONG_PORT', 8001),

    'ssl_port' => env('KONG_SSL_PORT', 8443),

    'timeout' => 2.0,

    'client_id' => env('KONG_CLIENT_ID', null),

    'client_secret' => env('KONG_CLIENT_SECRET', null),

    'provision_key' => env('KONG_PROVISION_KEY', null),

    'grant_type' => env('KONG_GRANT_TYPE', 'password'),

    'scope' => env('KONG_SCOPE', 'read'),

];
