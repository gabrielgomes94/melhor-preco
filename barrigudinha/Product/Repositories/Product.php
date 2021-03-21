<?php

namespace Barrigudinha\Product\Repositories;

use Integrations\Bling\Products\Client;
use Integrations\Bling\Products\Response\Product as ProductResponse;

class Product
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function get(string $sku): ProductResponse
    {
        $response = $this->client->get($sku);

        return $response;
    }
}
