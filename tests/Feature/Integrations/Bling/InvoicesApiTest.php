<?php

namespace Tests\Feature\Integrations\Bling;

use Illuminate\Support\Facades\Http;
use Src\Integrations\Bling\Invoices\Client;
use Src\Integrations\Bling\Invoices\Responses\Sanitizer;
use Tests\TestCase;

class InvoicesApiTest extends TestCase
{
    public function test_should_get_invoice_from_bling(): void
    {
        // Set
        $client = $this->setupClient();
        $number = '282534';
        $series = '1';
        $this->fakeGetRequest($number, $series);
        $expected = $this->getJsonFixture('Bling/Invoices/single-invoice-sanitized.json');

        // Actions
        $result = $client->get($number, $series);

        // Assertions
        $this->assertSame($expected, $result);
    }

    public function test_should_not_get_invoice_from_bling(): void
    {
        // Set
        $client = $this->setupClient();
        $number = '282534';
        $series = '999999';
        $this->fakeGet404Request($number, $series);

        // Actions
        $result = $client->get($number, $series);

        // Assertions
        $this->assertSame(['error' => 'A informacao desejada nao foi encontrada'], $result);
    }

    public function test_should_list_invoices_from_bling(): void
    {
        // Set
        $client = $this->setupClient();
        $this->fakeListRequest();
        $expected = $this->getJsonFixture('Bling/Invoices/list-invoices-sanitized.json');

        // Actions
        $result = $client->list();

        // Assertions
        $this->assertSame($expected, $result);
    }

    private function fakeGetRequest(string $number, string $series): void
    {
        $body = $this->getJsonFixture('Bling/Invoices/single-invoice.json');

        Http::fake([
            "bling.com.br/Api/v2/notafiscal/$number/$series/json/*" => Http::response($body, 200)
        ]);
    }

    private function fakeGet404Request(string $number, string $series): void
    {
        $body = $this->getJsonFixture('Bling/Errors/404.json');

        Http::fake([
            "bling.com.br/Api/v2/notafiscal/$number/$series/json/*" => Http::response($body, 200)
        ]);
    }

    private function fakeListRequest(): void
    {
        $body = $this->getJsonFixture('Bling/Invoices/list-invoices.json');

        Http::fake([
            "bling.com.br/Api/v2/notasfiscais/page=1/*" => Http::response($body, 200)
        ]);
    }

    private function setupClient(): Client
    {
        config(['integrations.bling.auth.apikey' => 'token']);
        $sanitizer = new Sanitizer();

        return new Client($sanitizer);
    }
}
