<?php

namespace Tests\Unit\Integrations\Bling\Products;

use Exception;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use Integrations\Bling\Products\Client;
use Src\Integrations\Bling\Products\Responses\Error;
use Integrations\Bling\Products\Responses\Factory;
use Src\Integrations\Bling\Products\Responses\Product;
use Mockery as m;
use Psr\Http\Message\RequestInterface;
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
        $product = m::mock(Product::class);

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
        $this->assertInstanceOf(Product::class, $result);
    }

    public function testShouldHandleConnectExceptions(): void
    {
        // Set
        $factory = m::mock(Factory::class);
        $httpClient = m::mock(GuzzleClient::class);
        $client = new Client($factory, $httpClient);
        $errorResponse = m::mock(Error::class);

        $request = m::mock(RequestInterface::class);

        // Expectations
        $httpClient->expects()
            ->request('GET', 'invalid/json', m::type('array'))
            ->andThrow(new ConnectException('Error connect exception' , $request));

        $factory->expects()
            ->makeError('ERRO: ou a conexão de internet está muito instável ou a API do Bling está fora do ar. Tente novamente mais tarde.')
            ->andReturn($errorResponse);

        // Actions
        $result = $client->get('invalid');

        // Assertions
        $this->assertInstanceOf(Error::class, $result);
    }

    public function testShouldHandleExceptions(): void
    {
        // Set
        $factory = m::mock(Factory::class);
        $httpClient = m::mock(GuzzleClient::class);
        $client = new Client($factory, $httpClient);
        $errorResponse = m::mock(Error::class);

        // Expectations
        $httpClient->expects()
            ->request('GET', 'invalid/json', m::type('array'))
            ->andThrow(Exception::class);

        $factory->expects()
            ->makeError('Aconteceu algum erro bizarro. Contate o suporte.')
            ->andReturn($errorResponse);

        // Actions
        $result = $client->get('invalid');

        // Assertions
        $this->assertInstanceOf(Error::class, $result);
    }
}
