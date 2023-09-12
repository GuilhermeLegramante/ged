<?php

return [
    'base_url' => env('PNCP_API_BASE_URL'),
    'cnpj' => env('CNPJ_ORGAO'),
    'login' => env('PNCP_LOGIN'),
    'password' => env('PNCP_PASSWORD'),

    'endpoints' => [
        'users' => '/v1/usuarios',
        'organs' => '/v1/orgaos',
    ],
];
