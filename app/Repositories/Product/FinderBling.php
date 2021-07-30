<?php

namespace App\Repositories\Product;

use Barrigudinha\Pricing\Repositories\Contracts\ProductFinder;
use Barrigudinha\Product\Clients\Contracts\ProductStore;
use Barrigudinha\Product\Product;

class FinderBling implements ProductFinder
{
    private ProductStore $client;

    public function __construct(ProductStore $client)
    {
        $this->client = $client;
    }

    /**
     * @return Product[]
     */
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

    public function get(string $sku): ?Product
    {
        $response = $this->client->get($sku, ['b2w', 'magalu']);

        if (!$product = $response->data()) {
            return null;
        }

        return $product;
    }
}
