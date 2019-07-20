<?php

return [

    'host' => env('KONG_HOST', 'kong'),

    'timeout' => 2.0,

    'client_id' => env('KONG_CLIENT_ID', null),

    'client_secret' => env('KONG_CLIENT_SECRET', null),

    'provision_key' => env('KONG_PROVISION_KEY', null),

    'grant_type' => [
        'authorize' => env('KONG_GRANT_TYPE_AUTHORIZE', 'password'),
        'refresh_token' => env('KONG_GRANT_TYPE_REFRESH', 'refresh_token')
    ],

    'scope' => env('KONG_SCOPE', 'read'),

];
