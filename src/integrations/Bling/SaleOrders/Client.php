<?php

namespace Src\Integrations\Bling\SaleOrders;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Src\Integrations\Bling\Base\Responses\BaseResponse;
use Src\Integrations\Bling\SaleOrders\Responses\Sanitizer;
use Src\Sales\Infrastructure\Bling\Responses\ResponseFactory;

class Client
{
    private const API_ENDPOINT = 'https://bling.com.br/Api/v2/pedidos/';

    private Sanitizer $sanitizer;

    public function __construct(Sanitizer $sanitizer)
    {
        $this->sanitizer = $sanitizer;
    }

    public function list(int $page = 1): array
    {
        $response = Http::withOptions([
            'base_uri' => self::API_ENDPOINT,
            'query' => [
                'apikey' => env('BLING_API_KEY'),
            ],
        ])->get("page={$page}/json/");

        return $this->sanitizer->sanitize($response);
    }
}
