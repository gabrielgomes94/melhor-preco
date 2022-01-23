<?php

namespace Src\Integrations\Bling\Products;

use Illuminate\Support\Facades\Http;
use Src\Integrations\Bling\Products\Requests\Endpoint;
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

    public function get(string $sku, string $status = Config::ACTIVE): array
    {
        $response = Http::withOptions(
            Config::getProduct($status)
        )->get(
            Endpoint::product($sku)
        );

        return $this->sanitizer->sanitize($response);
    }

    public function getPrice(string $sku, string $storeCode, string $status = Config::ACTIVE): array
    {
        $response = Http::withOptions(
            Config::getPrice($storeCode, $status)
        )->get(
            Endpoint::product($sku)
        );

        return $this->sanitizer->sanitize($response);
    }

    public function list(int $page = 1, string $status = Config::ACTIVE): array
    {
        $response = Http::withOptions(
            Config::listProducts($status)
        )->get(
            Endpoint::products($page)
        );

        return $this->sanitizer->sanitizeMultiple($response);
    }

    public function listPrice(string $storeCode, int $page = 1, string $status = Config::ACTIVE): array
    {
        $response = Http::withOptions(
            Config::listPrices($status, $storeCode)
        )->get(
            Endpoint::products($page)
        );

        return $this->sanitizer->sanitizeMultiple($response);
    }

    public function update(string $sku, string $xml): array
    {
        $response = Http::withOptions(
            Config::updateProduct($xml)
        )->post(
            Endpoint::product($sku)
        );

        return $this->sanitizer->sanitize($response);
    }

    public function updatePrice(string $sku, string $storeCode, string $productStoreSku, string $priceValue): array
    {
        $xml = ProductStoreTransformer::generateXML($productStoreSku, $priceValue);
        $response = Http::withOptions(
            Config::updatePrice($xml)
        )->post(
            Endpoint::productStore($sku, $storeCode)
        );

        return $this->sanitizer->sanitize($response);
    }
}
