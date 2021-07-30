<?php

namespace Integrations\Bling\Products\Repositories;

use Integrations\Bling\Products\Clients\ProductStore;

class Repository
{
    private ProductStore $client;

    public function __construct(ProductStore $client)
    {
        $this->client = $client;
    }

    public function get(string $sku, string $storeSlug)
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
