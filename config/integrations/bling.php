<?php

return [
    'auth' => [
        'apikey' => env('BLING_API_KEY')
    ],
    'base_uri' => 'https://Bling.com.br/Api/v2/',
    'apis' => [

    ],
//
    'categories' => [
        'base_uri' => 'https://Bling.com.br/Api/v2/categorias/'
    ],
    'invoices' => [
        'get' => [
            'base_uri' => 'https://Bling.com.br/Api/v2/notafiscal/',
        ],
        'list' => [
            'base_uri' => 'https://Bling.com.br/Api/v2/notasfiscais/',
        ],
    ],
    'products' => [
        'get' => [
            'base_uri' => 'https://Bling.com.br/Api/v2/produto/',
        ],
        'list' => [
            'base_uri' => 'https://Bling.com.br/Api/v2/produtos/',
        ],
        'updatePrice' => [
            'base_uri' => 'https://bling.com.br/Api/v2/produtoLoja/',
            'headers' => [
                'Content-Type' => 'text/xml',
            ],
        ],
        'updateProduct' => [
            'base_uri' => 'https://bling.com.br/Api/v2/produto/',
        ],
    ],
    'sale_orders' => [
        'list' => [
            'base_uri' => 'https://bling.com.br/Api/v2/pedidos/',
        ]
    ]
];
