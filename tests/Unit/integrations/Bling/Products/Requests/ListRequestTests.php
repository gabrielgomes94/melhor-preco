<?php

namespace Tests\Unit\Integrations\Bling\Products\Requests;

use GuzzleHttp\Client;
use Integrations\Bling\Products\Requests\GetRequest;
use Integrations\Bling\Products\Requests\ListRequest;
use Mockery as m;
use Psr\Http\Message\ResponseInterface;
use Tests\TestCase;

class ListRequestTests extends TestCase
{
    public function testShouldSendRequestToListProducts(): void
    {
        // Set
        $httpClient = m::mock(Client::class);
        $options = [
            'base_uri' => 'https://Bling.com.br/Api/v2/produtos/',
            'query' => [
                'apikey' => env('BLING_API_KEY'),
                'estoque' => 'S',
                'imagem' => 'S',
            ],
        ];
        $request = new ListRequest($httpClient, $options);
        $response = m::mock(ResponseInterface::class);

        // Expect
        $httpClient->expects()
            ->request('GET', 'page=1/json/', $options)
            ->andReturn($response);

        // Act
        $request->all();
    }
}
