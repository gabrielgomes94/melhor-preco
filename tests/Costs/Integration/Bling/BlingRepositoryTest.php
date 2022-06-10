<?php

namespace Tests\Costs\Integration\Bling;

use Mockery;
use Src\Costs\Infrastructure\Bling\Responses\Factory;
use Src\Costs\Infrastructure\Bling\Responses\PurchaseInvoicesResponse;
use Src\Costs\Infrastructure\Laravel\Models\PurchaseInvoice;
use Src\Integrations\Bling\Invoices\Client;
use Tests\Data\Models\Costs\PurchaseInvoiceData;
use Tests\TestCase;

// @todo: Mover para contexto de Integrations
class BlingRepositoryTest extends TestCase
{
    public function test_should_list_purchase_invoices(): void
    {
        // Set
        $invoices = [
            PurchaseInvoiceData::make(),
            PurchaseInvoiceData::make(),
            PurchaseInvoiceData::make(),
        ];

        $clientResponse = $this->getResponse();
        $client = $this->mockClient($clientResponse);
        $purchaseInvoicesResponse = $this->mockPurchaseInvoicesResponse($invoices);
        $responseFactory = $this->mockResponseFactory($clientResponse, $purchaseInvoicesResponse);

        $repository = new BlingRepository($client, $responseFactory);

        // Act
        $result = $repository->listPurchaseInvoice();

        // Assert
        $this->assertSame(6, count($result));
        $this->assertContainsOnlyInstancesOf(PurchaseInvoice::class, $result);
    }

    public function test_should_return_empty_when_there_is_no_purchase_invoices(): void
    {
        // Set
        $client = $this->mockClientWhenThereIsNoPurchaseInvoices();
        $purchaseInvoicesResponse = $this->mockPurchaseInvoicesResponseWhenThereIsNoPurchaseInvoices();
        $responseFactory = $this->mockResponseFactoryWhenThereIsNoPurchaseInvoices($purchaseInvoicesResponse);

        $repository = new BlingRepository($client, $responseFactory);

        // Act
        $result = $repository->listPurchaseInvoice();

        // Assert
        $this->assertEmpty($result);
    }

    private function mockClient(array $response): Client
    {
        $client = Mockery::mock(Client::class);

        $client->expects()
            ->list(Mockery::type('integer'))
            ->times(2)
            ->andReturn($response);

        return $client;
    }

    private function mockClientWhenThereIsNoPurchaseInvoices(): Client
    {
        $client = Mockery::mock(Client::class);

        $client->expects()
            ->list(Mockery::type('integer'))
            ->andReturn([]);

        return $client;
    }

    private function mockPurchaseInvoicesResponse(array $invoices): PurchaseInvoicesResponse
    {
        $purchaseInvoicesResponse = Mockery::mock(PurchaseInvoicesResponse::class);

        $purchaseInvoicesResponse->expects()
            ->data()
            ->times(2)
            ->andReturn($invoices);

        $purchaseInvoicesResponse->expects()
            ->isEmpty()
            ->andReturnFalse();

        $purchaseInvoicesResponse->expects()
            ->isEmpty()
            ->andReturnTrue();

        return $purchaseInvoicesResponse;
    }

    private function mockPurchaseInvoicesResponseWhenThereIsNoPurchaseInvoices()
    {
        $purchaseInvoicesResponse = Mockery::mock(PurchaseInvoicesResponse::class);

        $purchaseInvoicesResponse->expects()
            ->data()
            ->andReturn([]);

        $purchaseInvoicesResponse->expects()
            ->isEmpty()
            ->andReturnTrue();

        return $purchaseInvoicesResponse;
    }

    private function mockResponseFactory(
        array $response,
        PurchaseInvoicesResponse $purchaseInvoicesResponse
    ): Factory
    {
        $responseFactory = Mockery::mock(Factory::class);

        $responseFactory->expects()
            ->make($response)
            ->times(2)
            ->andReturn($purchaseInvoicesResponse);

        return $responseFactory;
    }

    private function mockResponseFactoryWhenThereIsNoPurchaseInvoices(
        PurchaseInvoicesResponse $purchaseInvoicesResponse
    ): Factory
    {
        $responseFactory = Mockery::mock(Factory::class);

        $responseFactory->expects()
            ->make([])
            ->andReturn($purchaseInvoicesResponse);

        return $responseFactory;
    }

    private function getResponse(): array
    {
        return $this->getJsonFixture('Bling/Invoices/PurchaseInvoices/list-purchase-invoices-sanitized.json');
    }
}
