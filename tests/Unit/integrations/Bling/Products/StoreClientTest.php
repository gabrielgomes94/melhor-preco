<?php

namespace Tests\Unit\Integrations\Bling\Products;

use Integrations\Bling\Products\Requests\GetRequest;
use Integrations\Bling\Products\StoreClient;
use Mockery as m;
use Tests\TestCase;

class StoreClientTest extends TestCase
{
    public function testShouldGetProductsWithStores(): void
    {
        // Set
        $request = m::mock(GetRequest::class);
        $client = new StoreClient($request);

        $sku = '1232';
        $stores = [
            'magalu',
            'b2w',
            'mercado_livre',
        ];

        // Expectations


        // Act
        $client->getWithStores($sku, $stores);

        // Assert

    }

    public function testShouldHandleConnectExceptions(): void
    {

    }

    public function testShouldHandleExceptions(): void
    {

    }
}
