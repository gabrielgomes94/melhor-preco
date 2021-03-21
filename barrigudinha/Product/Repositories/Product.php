<?php

namespace Barrigudinha\Product\Repositories;

use Barrigudinha\Product\Product as ProductData;
use Integrations\Bling\Products\Client;


class Product
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
