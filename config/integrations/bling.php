<?php

return [
    'auth' => [
        'apikey' => env('BLING_API_KEY')
    ],
    'invoices' => [
        'get' => [
            'base_uri' => 'https://Bling.com.br/Api/v2/notafiscal/',
        ],
        'list' => [
            'base_uri' => 'https://Bling.com.br/Api/v2/notasfiscais/',
        ]
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
        ]

    ],
    'endpoints' => [
        'categories' => [
            'list' => [
                'base_uri' => 'https://Bling.com.br/Api/v2/categorias/',
                'query' => [
                    'apikey' => env('BLING_API_KEY'),
                ],
            ],
        ],
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
                'base_uri' => 'https://bling.com.br/Api/v2/produtoLoja/',
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
