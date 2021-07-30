<?php

namespace Integrations\Bling\Products\Repositories;

//use Barrigudinha\Product\Clients\Contracts\ProductStore;
use Integrations\Bling\Products\Clients\ProductStore;
use Integrations\Bling\Products\Data\Product;

class Repository
{
    private Product $productClient;
    private ProductStore $client;

    public function __construct(ProductStore $client)
    {
        $this->client = $client;
    }

    public function get(string $sku, string $storeSlug): ?Product
    {
        $response = $this->client->get($sku, [$storeSlug]);

        if (!$product = $response->data()) {
            return null;
        }

        return $product;
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
