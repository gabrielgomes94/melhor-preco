<?php

return [
    'endpoints' => [
        'products' => [
            'get' => [
                'base_uri' => 'https://Bling.com.br/Api/v2/produto/',
                'query' => [
                    'apikey' => env('BLING_API_KEY'),
                    'estoque' => 'S',
                    'imagem' => 'S',
                ],
            ],
            'list' => [
                'base_uri' => 'https://Bling.com.br/Api/v2/produtos/',
                'query' => [
                    'apikey' => env('BLING_API_KEY'),
                    'estoque' => 'S',
                    'imagem' => 'S',
                ],
            ],
            'update' => [
                'base_uri' => 'https://bling.com.br/Api/v2/produto/',
                'headers' => [
                    'Content-Type' => 'text/xml',
                ],
                'query' => [
                    'apikey' => env('BLING_API_KEY'),
                ],
            ],
        ],
    ],
];
