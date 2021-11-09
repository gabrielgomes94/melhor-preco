<?php

namespace Src\Integrations\Bling\SaleOrders\Requests;

class Config
{
    public static function listSales(): array
    {
        return [
            'base_uri' => 'https://bling.com.br/Api/v2/pedidos/',
            'query' => [
                'apikey' => env('BLING_API_KEY'),
            ],
        ];
    }
}
