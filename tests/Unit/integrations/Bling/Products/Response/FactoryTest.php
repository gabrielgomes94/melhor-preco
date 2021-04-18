<?php

namespace Tests\Unit\Integrations\Bling\Products\Response;

use Barrigudinha\Product\Product;
use Integrations\Bling\Products\Responses\ErrorResponse;
use Integrations\Bling\Products\Responses\Factory;
use Integrations\Bling\Products\Responses\ProductResponse;
use Integrations\Bling\Products\Transformers\Sanitizer;
use Integrations\Bling\Products\Transformers\Transformer;
use Mockery as m;
use Psr\Http\Message\ResponseInterface;
use Tests\TestCase;

class FactoryTest extends TestCase
{
    public function testShouldMakeWithErrorsWhenThereIsNoResponse(): void
    {
        // Set
        $transformer = new Transformer();
        $sanitizer = new Sanitizer();
        $factory = new Factory($transformer, $sanitizer);

        // Act
        $result = $factory->makeError(error: 'Invalid error!');

        // Assert
        $this->assertInstanceOf(ErrorResponse::class, $result);
        $this->assertNull($result->product());
        $this->assertTrue($result->hasErrors());
        $this->assertSame(['Invalid error!'], $result->errors());
    }

    public function testShouldMakeWithErrorsWhenThereIsNoDataInResponse(): void
    {
        // Set
        $response = m::mock(ResponseInterface::class);
        $emptyData = "{}";
        $transformer = new Transformer();
        $sanitizer = new Sanitizer();
        $factory = new Factory($transformer, $sanitizer);

        // Expect
        $response->expects()
            ->getBody()
            ->andReturn($emptyData);

        // Act
        $result = $factory->make($response);

        // Assert
        $this->assertInstanceOf(ErrorResponse::class, $result);
        $this->assertNull($result->product());
        $this->assertTrue($result->hasErrors());
        $this->assertSame(['Invalid response!'], $result->errors());
    }

    public function testShouldMakeProductResponseWithErrors(): void
    {
        // Set
        $response = m::mock(ResponseInterface::class);
        $data = $this->getFixture('integrations/Bling/Responses/products-with-errors.json');
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
        $this->assertInstanceOf(ErrorResponse::class, $result);
        $this->assertNull($result->product());
        $this->assertTrue($result->hasErrors());
        $this->assertSame(['A informacao desejada nao foi encontrada'], $result->errors());
    }

    public function testShouldMakeSuccessfullProductResponse(): void
    {
        // Set
        $response = m::mock(ResponseInterface::class);
        $data = $this->getFixture('integrations/Bling/Responses/products.json');
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
}
