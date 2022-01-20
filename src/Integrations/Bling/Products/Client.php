<?php

namespace Src\Integrations\Bling\Products;

use Illuminate\Support\Facades\Http;
use Src\Integrations\Bling\Products\Requests\PriceTransformer as ProductStoreTransformer;
use Src\Integrations\Bling\Products\Requests\Config;
use Src\Integrations\Bling\Products\Responses\Sanitizer;

class Client
{
    private Sanitizer $sanitizer;

    public function __construct(Sanitizer $sanitizer)
    {
        $this->sanitizer = $sanitizer;
    }

    public function get(string $sku, string $status = Config::ACTIVE, ?string $store = null): array
    {
        $storeCode = config("stores_code.{$store}");

        $response = Http::withOptions(
            Config::getProduct($status, $storeCode)
        )->get("$sku/json");

        return $this->sanitizer->sanitize($response);
    }

    public function list(int $page = 1, string $status = Config::ACTIVE): array
    {
        $response = Http::withOptions(
            Config::listProducts($status)
        )->get("page={$page}/json/");

        return $this->sanitizer->sanitizeMultiple($response);
    }

    public function listPrice(string $storeCode, int $page = 1, string $status = Config::ACTIVE): array
    {
        $response = Http::withOptions(
            Config::listProducts($status, $storeCode)
        )->get("page={$page}/json/");

        return $this->sanitizer->sanitizeMultiple($response);
    }

    public function update(string $sku, string $xml): array
    {
        $response = Http::withOptions(
            Config::updateProduct($xml)
        )->post("{$sku}/json");

        return $this->sanitizer->sanitize($response);
    }

    public function updatePrice(string $sku, string $storeCode, string $productStoreSku, string $priceValue): array
    {
        $xml = ProductStoreTransformer::generateXML($productStoreSku, $priceValue);

        $response = Http::withOptions(
            Config::updateProduct($xml)
        )->post("{$storeCode}/{$sku}/json/");

        return $this->sanitizer->sanitize($response);
    }

    public function getPrice(string $sku, string $storeCode): array
    {
        $response = Http::withOptions(
            [
                'base_uri' => 'https://bling.com.br/Api/v2/produto/',
                'query' => [
                    'apikey' => env('BLING_API_KEY'),
                    'loja' => $storeCode,
                ],
            ]
        )->get("{$sku}/json");


        return $this->sanitizer->sanitize($response);
    }
}
