<?php

namespace Tests\Unit\Integrations\Bling\Products;

use Exception;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use Integrations\Bling\Products\Client;
use Integrations\Bling\Products\Response\Factory;
use Integrations\Bling\Products\Response\ProductResponse;
use Mockery as m;
use Psr\Http\Message\ResponseInterface;
use Tests\TestCase;

class ClientTest extends TestCase
{
    public function testShouldSendGetRequestSuccessfully(): void
    {
        // Set
        $factory = m::mock(Factory::class);
        $httpClient = m::mock(GuzzleClient::class);
        $client = new Client($factory, $httpClient);
        $response = m::mock(ResponseInterface::class);
        $product = m::mock(ProductResponse::class);

        // Expectations
        $httpClient->expects()
            ->request('GET', '1234/json', m::type('array'))
            ->andReturn($response);

        $factory->expects()
            ->make($response)
            ->andReturn($product);

        // Actions
        $result = $client->get('1234');

        // Assertions
        $this->assertInstanceOf(ProductResponse::class, $result);
    }

    public function testShouldHandleExceptions(): void
    {
        // Set
        $factory = m::mock(Factory::class);
        $httpClient = m::mock(GuzzleClient::class);
        $client = new Client($factory, $httpClient);
        $product = m::mock(ProductResponse::class);

        // Expectations
        $httpClient->expects()
            ->request('GET', 'invalid/json', m::type('array'))
            ->andThrow(Exception::class);

        $factory->expects()
            ->makeWithError('Aconteceu algum erro bizarro. Contate o suporte.')
            ->andReturn($product);

        // Actions
        $result = $client->get('invalid');

        // Assertions
        $this->assertInstanceOf(ProductResponse::class, $result);
    }
}
