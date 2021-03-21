<?php

namespace Tests\Unit\Integrations\Bling\Products\Response\Transformer;

use Integrations\Bling\Products\Response\Transformers\Sanitizer;
use Tests\TestCase;
use Tests\Unit\fixtures\integrations\Bling\Data\Product;

class SanitizerTest extends TestCase
{
    public function testShouldSanitizeErrors(): void
    {
        // Set
        $sanitizer = new Sanitizer();
        $data = $this->getJsonFixture('integrations/Bling/Responses/products-with-errors.json');
        $expect = ['error' => 'A informacao desejada nao foi encontrada'];

        // Act
        $result = $sanitizer->sanitize($data);

        // Assert
        $this->assertSame($expect, $result);
    }

    public function testShouldSanitizeProducts(): void
    {
        // Set
        $sanitizer = new Sanitizer();
        $data = $this->getJsonFixture('integrations/Bling/Responses/products.json');
        $product = Product::getData();
        $expect = ['product' => $product];

        // Act
        $result = $sanitizer->sanitize($data);

        // Assert
        $this->assertSame($expect, $result);
    }

    public function testShouldNotSanitizeData(): void
    {
        // Set
        $sanitizer = new Sanitizer();
        $data = [
            'xpto' => 'random',
            'foo' => 'bar',
        ];

        // Act
        $result = $sanitizer->sanitize($data);

        // Assert
        $this->assertEmpty($result);
    }
}
