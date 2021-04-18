<?php

namespace Tests\Unit\Integrations\Bling\Products\Requests;

use GuzzleHttp\Client;
use Integrations\Bling\Products\Requests\Request;
use Mockery as m;
use Psr\Http\Message\ResponseInterface;
use Tests\TestCase;

class RequestTest extends TestCase
{
    public function testShouldSendGetRequest()
    {
        // Set
        $httpClient = m::mock(Client::class);
        $response = m::mock(ResponseInterface::class);
        $request = new Request($httpClient);
        $options = [
            'base_uri' => 'https://Bling.com.br/Api/v2/produto/',
            'query' => [
                'apikey' => env('BLING_API_KEY'),
                'estoque' => 'S',
                'imagem' => 'S',
            ],
        ];

        // Expect
        $httpClient->expects()
            ->request('GET', '12332/json', $options)
            ->andReturn($response);

        // Act
        $result = $request->get('12332');
    }

    public function testShouldSendGetStoreRequest()
    {
        // Set
        $httpClient = m::mock(Client::class);
        $response = m::mock(ResponseInterface::class);
        $request = new Request($httpClient);
        $options = [
            'base_uri' => 'https://Bling.com.br/Api/v2/produto/',
            'query' => [
                'apikey' => env('BLING_API_KEY'),
                'estoque' => 'S',
                'imagem' => 'S',
                'loja' => '203454036',
            ],
        ];

        // Expect
        $httpClient->expects()
            ->request('GET', '12332/json', $options)
            ->andReturn($response);

        // Act
        $result = $request->getStore('12332', 'magalu');
    }
}
