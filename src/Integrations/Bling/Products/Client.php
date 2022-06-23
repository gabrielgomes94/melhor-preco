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

    public function get(string $erpToken, string $sku, string $status = Config::ACTIVE): array
    {
        $config = Config::getProduct($erpToken, $status);
        $endpoint = Endpoint::product($sku);
        $response = Http::withOptions($config)->get($endpoint);

        return $this->sanitizer->sanitize($response);
    }

    public function getPrice(string $erpToken, string $sku, string $storeCode, string $status = Config::ACTIVE): array
    {
        $config = Config::getPrice($storeCode, $status);
        $endpoint = Endpoint::product($sku);
        $response = Http::withOptions($config)->get($endpoint);

        return $this->sanitizer->sanitize($response);
    }

    public function list(string $erpToken, int $page = 1, string $status = Config::ACTIVE): array
    {
        $config = Config::listProducts($erpToken, $status);
        $endpoint = Endpoint::products($page);
        $response = Http::withOptions($config)->get($endpoint);

        return $this->sanitizer->sanitizeMultiple($response);
    }

    public function listPrice(
        string $erpToken,
        string $storeCode,
        int $page = 1,
        string $status =
        Config::ACTIVE
    ): array
    {
        $config = Config::listPrices($erpToken, $status, $storeCode);
        $endpoint = Endpoint::products($page);
        $response = Http::withOptions($config)->get($endpoint);

        return $this->sanitizer->sanitizeMultiple($response);
    }

    public function update(string $erpToken, string $sku, string $xml): array
    {
        $config = Config::updateProduct($erpToken, $xml);
        $endpoint = Endpoint::product($sku);
        $response = Http::withOptions($config)->post($endpoint);

        return $this->sanitizer->sanitize($response);
    }

    public function updatePrice(
        string $erpToken,
        string $sku,
        string $storeCode,
        string $productStoreSku,
        string $priceValue
    ): array
    {
        $xml = ProductStoreTransformer::generateXML($productStoreSku, $priceValue);
        $config = Config::updatePrice($erpToken, $xml);
        $endpoint = Endpoint::productStore($sku, $storeCode);
        $response = Http::withOptions($config)->post($endpoint);

        return $this->sanitizer->sanitize($response);
    }
}
