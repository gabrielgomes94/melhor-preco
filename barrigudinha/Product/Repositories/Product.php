<?php

namespace Barrigudinha\Product\Repositories;

use Barrigudinha\Product\Entities\Product as ProductData;
use Barrigudinha\Product\Repositories\Contracts\Product as ProductInterface;
use Integrations\Bling\Products\Client;

class Product implements ProductInterface
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function get(string $sku): ?ProductData
    {
        $response = $this->client->get($sku);

        return $response->product();
    }
}
