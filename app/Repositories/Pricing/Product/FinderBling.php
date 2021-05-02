<?php

namespace App\Repositories\Pricing\Product;

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

    public function get(string $sku): ?PricingProduct
    {
        $response = $this->client->getWithStores($sku, ['magalu', 'b2w', 'mercado_livre']);

        if (!$product = $response->product()) {
            return null;
        }

        return $product->toPricing();
    }
}
