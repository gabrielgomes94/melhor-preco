<?php

namespace Tests\Unit\Integrations\Bling\Products;

use Barrigudinha\Product\Product;
use Integrations\Bling\Products\Response\Factory;
use Integrations\Bling\Products\Response\ProductResponse;
use Integrations\Bling\Products\Response\Transformers\Sanitizer;
use Integrations\Bling\Products\Response\Transformers\Transformer;
use Mockery as m;
use Psr\Http\Message\ResponseInterface;
use Tests\TestCase;

class FactoryTest extends TestCase
{
    public function testShouldMakeSuccessfullProductResponse(): void
    {
        // Set
        $response = m::mock(ResponseInterface::class);
        $data = $this->getFixture('integrations/Bling/products.json');
        $transformer = new Transformer();
        $sanitizer = new Sanitizer();
        $factory = new Factory($transformer, $sanitizer);

        // Expect
        $response->expects()
            ->getBody()
            ->andReturn($data);

        // Act
        $result = $factory->make($response);

        // Assert
        $this->assertInstanceOf(ProductResponse::class, $result);
        $this->assertInstanceOf(Product::class, $result->product());
        $this->assertFalse($result->hasErrors());
    }

    public function testShouldMakeProductResponseWithErrors(): void
    {
        // Set
        $response = m::mock(ResponseInterface::class);
        $data = $this->getFixture('integrations/Bling/products-with-errors.json');
        $transformer = new Transformer();
        $sanitizer = new Sanitizer();
        $factory = new Factory($transformer, $sanitizer);

        // Expect
        $response->expects()
            ->getBody()
            ->andReturn($data);


        // Act
        $result = $factory->make($response);

        // Assert
        $this->assertInstanceOf(ProductResponse::class, $result);
        $this->assertNull($result->product());
        $this->assertTrue($result->hasErrors());
    }
}
