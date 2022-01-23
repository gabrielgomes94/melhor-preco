<?php

namespace Tests\Feature\Integrations\Bling;

use Illuminate\Support\Facades\Http;
use Src\Integrations\Bling\Categories\Client;
use Src\Integrations\Bling\Categories\Responses\Sanitizer;
use Tests\TestCase;

class CategoriesApiTests extends TestCase
{
    public function test_should_list_categories_from_bling(): void
    {
        // Set
        $client = $this->setupClient();
        $this->fakeBlingApiRequest();
        $expected = $this->getJsonFixture('Bling/Categories/list-categories-sanitized.json');

        // Act
        $result = $client->list();

        // Assert
        $this->assertSame($expected, $result);
    }

    private function fakeBlingApiRequest(): void
    {
        $body = $this->getJsonFixture('Bling/Categories/list-categories.json');

        Http::fake([
            'bling.com.br/Api/v2/categorias/*' => Http::response($body),
        ]);
    }

    private function setupClient(): Client
    {
        config(['integrations.bling.auth.apikey' => 'token']);
        $sanitizer = new Sanitizer();

        return new Client($sanitizer);
    }
}
