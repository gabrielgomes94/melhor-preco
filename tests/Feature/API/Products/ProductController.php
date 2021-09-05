<?php

namespace Tests\Feature\API\Products;

use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Integrations\Bling\Products\Requests\GetRequest;
use Tests\TestCase;

class ProductController extends TestCase
{
    public function test_should_get_products_from_bling_api(): void
    {
        // Set
        $user = User::factory()->create();
        $this->mockRequest('Bling/Products/products.json');

        $expected = [
            'product' => [
                "sku" => "1211",
                "name" => "Carrinho Veneto Aviador Azul",
                "brand" => "Galzerano",
                "images" => [],
                "stock" => null,
            ],
        ];

        // Actions
        $response = $this
            ->actingAs($user)
            ->get('/api/product/1211');

        // Assertions
        $response->assertStatus(200);
        $response->assertExactJson($expected);
    }

    public function test_should_not_get_products_from_bling_api(): void
    {
        // Set
        $user = User::factory()->create();
        $this->mockRequest('Bling/Products/products-with-errors.json');

        $expected = [
            'errors' => 'A informacao desejada nao foi encontrada',
        ];

        // Actions
        $response = $this
            ->actingAs($user)
            ->get('/api/product/1211');

        // Assertions
        $response->assertStatus(404);
        $response->assertExactJson($expected);
    }

    private function mockRequest(string $fixture): void
    {
        $mock = new MockHandler([
            new Response(
                200,
                [],
                $this->getFixture($fixture)
            ),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);
        $this->app->bind(GetRequest::class, function () use ($client) {
            return new GetRequest($client);
        });
    }
}
