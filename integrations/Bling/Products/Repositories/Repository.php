<?php

namespace Integrations\Bling\Products\Repositories;

use Integrations\Bling\Products\Clients\ProductStore;
use Integrations\Bling\Products\Responses\BaseResponse;
use Integrations\Bling\Products\Responses\Contracts\Response;
use Integrations\Bling\Products\Responses\Factories\ProductResponse;

class Repository
{
    private ProductStore $client;
    private ProductResponse $productResponse;

    public function __construct(ProductStore $client, ProductResponse $productResponse)
    {
        $this->client = $client;
        $this->productResponse = $productResponse;
    }

    public function get(string $sku, array $stores = []): Response
    {
        if (!$stores) {
            $response = $this->client->get($sku);

            return $this->productResponse->make($response);
        }

        foreach ($stores as $store) {
            $storeResponses[] = $this->client->get($sku, $store)->data();
        }

        return $this->productResponse->makeStores($storeResponses ?? []);
    }

    public function all(): array
    {
        $page = 0;
        $productsList = [];

        do {
            $page++;
            $products = $this->client->list($page)->data();

            foreach ($products as $product) {
                $productsList[] = $product;
            }
        } while (!empty($products));

        return $productsList ?? [];
    }

    /**
     * public function allWithStore();
     * public function getWithStore();
     * public function getWithStore();
     */
}
