<?php

namespace Tests\Unit\Barrigudinha\Product\Repositories;

use Barrigudinha\Product\Product as ProductData;
use Barrigudinha\Product\Repositories\Product;
use Integrations\Bling\Products\Client;
use Mockery as m;
use Tests\TestCase;
use Integrations\Bling\Products\Responses\Product as ProductResponse;

class ProductTest extends TestCase
{
    public function testShouldGetProduct(): void
    {
        // Set
        $client = m::mock(Client::class);
        $repository = new Product($client);

        $response = new Product(
            data: [
                'sku' => '1231',
                'name' => 'Carrinho',
                'brand' => 'Galzerano',
            ]
        );

        // Expect
        $client->expects()
            ->get('1231')
            ->andReturn($response);

        // Act
        $result = $repository->get('1231');

        // Assert
        $this->assertInstanceOf(Product::class, $result);
        $this->assertInstanceOf(ProductData::class, $result->product());
        $this->assertSame([], $result->errors());
    }
}
