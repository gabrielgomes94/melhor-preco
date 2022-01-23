<?php

namespace Tests\Feature\Integrations\Bling;

use Illuminate\Support\Facades\Http;
use Src\Integrations\Bling\SaleOrders\Client;
use Src\Integrations\Bling\SaleOrders\Responses\Sanitizer;
use Tests\TestCase;

class SaleOrderApiTest extends TestCase
{
    public function test_should_list_sale_orders_from_bling(): void
    {
        // Set
        $client = $this->setupClient();
        $this->fakeBlingApiRequest();
        $expected = $this->getJsonFixture('Bling/SaleOrders/list-sale-orders-sanitized.json');

        // Act
        $result = $client->list();

        // Assert
        $this->assertSame($expected, $result);
    }

    private function fakeBlingApiRequest(): void
    {
        $body = $this->getJsonFixture('Bling/SaleOrders/list-sale-orders.json');

        Http::fake([
            'bling.com.br/Api/v2/pedidos/*' => Http::response($body),
        ]);
    }

    private function setupClient(): Client
    {
        config(['integrations.bling.auth.apikey' => 'token']);
        $sanitizer = new Sanitizer();

        return new Client($sanitizer);
    }
}
