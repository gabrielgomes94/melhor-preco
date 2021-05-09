<?php

namespace Tests\Unit\Integrations\Bling\Products\Response;

use Barrigudinha\Product\Product;
use Integrations\Bling\Products\Responses\Product;
use Tests\TestCase;

class ProductResponseTest extends TestCase
{
    public function testShouldCreateProductResponseWithData(): void
    {
        // Set
        $data = [
            'product' => [
                'sku' => '1122',
                'name' => 'Carrinho de Bebê',
                'brand' => 'Galzerano',
                'purchasePrice' => 12.00,
                'images' => [
                    'link-to-image-1',
                    'link-to-image-2',
                    'link-to-image-3',
                ],
                'stock' => 0,
            ],
        ];

        $expected = Product::createFromArray($data['product']);

        // Act
        $result = new Product(data: $data);

        // Assert
        $this->assertInstanceOf(Product::class, $result->product());
        $this->assertEquals($expected, $result->product());
        $this->assertEmpty($result->errors());
        $this->assertFalse($result->hasErrors());
    }
}
