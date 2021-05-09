<?php

namespace App\Repositories\Pricing\Product;

use Barrigudinha\Pricing\Data\Product;
use Barrigudinha\Pricing\Data\Product as PricingProduct;
use Barrigudinha\Pricing\Repositories\Contracts\ProductFinder;
use Integrations\Bling\Products\StoreClient;

class FinderBling implements ProductFinder
{
    private StoreClient $client;

    public function __construct(StoreClient $client)
    {
        $this->client = $client;
    }

    /**
     * @return Product[]
     */
    public function all(): array
    {
        $page = 1;
        $response = $this->client->list($page);
        $products = $response->products();

        while(!empty($products)) {
            $page++;

            $products = $this->client->list($page)->products();

        }
    }

    public function get(string $sku): ?PricingProduct
    {
        $response = $this->client->get($sku, ['magalu', 'b2w', 'mercado_livre']);

        if (!$product = $response->product()) {
            return null;
        }

        return $product->toPricing();
    }
}
