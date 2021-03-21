<?php

namespace Tests\Unit\Integrations\Bling\Products\Response;

use Barrigudinha\Product\Product;
use Integrations\Bling\Products\Response\ProductResponse;
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
        $result = new ProductResponse(data: $data);

        // Assert
        $this->assertInstanceOf(Product::class, $result->product());
        $this->assertEquals($expected, $result->product());
        $this->assertEmpty($result->errors());
        $this->assertFalse($result->hasErrors());
    }

    public function testShouldCreateProductResponseWithErrors(): void
    {
        // Act
        $result = new ProductResponse(error: 'Invalid product response.');

        // Assert
        $this->assertNull($result->product());
        $this->assertSame(['Invalid product response.'], $result->errors());
        $this->assertTrue($result->hasErrors());
    }
}
