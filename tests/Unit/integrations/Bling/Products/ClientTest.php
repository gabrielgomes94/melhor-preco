<?php

namespace Tests\Unit\integrations\Bling;

use GuzzleHttp\Client as GuzzleClient;
use Integrations\Bling\Client;
use Mockery as m;
use Tests\TestCase;

class ClientTest extends TestCase
{
    public function testShouldSendRequest(): void
    {
        // Set
        $httpClient = m::mock(GuzzleClient::class);
        $client = new Client($httpClient);
        $method = 'GET';
        $uri = '1234/json';

        // Expectations
        $httpClient
            ->expects()
            ->request($method, $uri)
            ->andReturn();

        // Actions
        $client->request('GET', $uri);


    }
}
