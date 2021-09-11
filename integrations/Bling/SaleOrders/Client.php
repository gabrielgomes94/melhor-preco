<?php

namespace Integrations\Bling\SaleOrders;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class Client
{
    private const API_ENDPOINT = 'https://bling.com.br/Api/v2/pedidos/json/';

    private const SITUATIONS = 'https://bling.com.br/Api/v2/situacao/Vendas/json';

    public function list(): Response
    {
        return Http::withOptions([
            'base_uri' => self::API_ENDPOINT,
            'query' => [
                'apikey' => env('BLING_API_KEY'),
                'filters' => 'dataEmissao[01/08/2021 TO 31/08/2021]'
            ],
        ])->get('');
    }
}
