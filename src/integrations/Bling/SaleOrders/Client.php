<?php

namespace Src\Integrations\Bling\SaleOrders;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Src\Integrations\Bling\SaleOrders\Responses\Sanitizer;

class Client
{
    private const API_ENDPOINT = 'https://bling.com.br/Api/v2/pedidos/json/';

    private const SITUATIONS = 'https://bling.com.br/Api/v2/situacao/Vendas/json';

    private Sanitizer $sanitizer;

    public function __construct(Sanitizer $sanitizer)
    {
        $this->sanitizer = $sanitizer;
    }

    public function list(): array
    {
        $response = Http::withOptions([
            'base_uri' => self::API_ENDPOINT,
            'query' => [
                'apikey' => env('BLING_API_KEY'),
                'filters' => 'dataEmissao[01/08/2021 TO 31/08/2021]'
            ],
        ])->get('');

        return $this->sanitizer->sanitize($response);
    }
}
