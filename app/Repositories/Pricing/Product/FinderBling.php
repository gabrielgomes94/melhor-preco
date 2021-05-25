<?php

namespace App\Repositories\Pricing\Product;

use Barrigudinha\Pricing\Data\Product as PricingProduct;
use Barrigudinha\Pricing\Repositories\Contracts\ProductFinder;
use Barrigudinha\Product\Clients\Contracts\ProductStore;
use Barrigudinha\Product\Product as ProductData;

class FinderBling implements ProductFinder
{
    private ProductStore $client;

    public function __construct(ProductStore $client)
    {
        $this->client = $client;
    }

    /**
     * @return ProductData[]
     */
    public function all(): array
    {
        $page = 1;
        $response = $this->client->list($page);
        $products = $response->data();
        $productsList = [];

        foreach ($products as $product) {
            $productsList[] = $product;
        }

        while (!empty($products)) {
            $page++;
            $products = $this->client->list($page)->data();

            foreach ($products as $product) {
                $productsList[] = $product;
            }
        }

        return $productsList ?? [];
    }

    public function get(string $sku): ?PricingProduct
    {
        $response = $this->client->get($sku, ['b2w']);

        if (!$product = $response->product()) {
            return null;
        }

        return $product->toPricing();
    }
}
