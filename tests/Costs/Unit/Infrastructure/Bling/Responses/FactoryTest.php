<?php

namespace Tests\Costs\Unit\Infrastructure\Bling\Responses;

use Src\Costs\Infrastructure\Bling\Responses\Factory;
use Src\Costs\Infrastructure\Bling\Responses\PurchaseInvoicesResponse;
use Src\Integrations\Bling\Base\Responses\ErrorResponse;
use Tests\TestCase;
use function Src\Costs\Infrastructure\Bling\Responses\count;

class FactoryTest extends TestCase
{
    /**
     * @dataProvider getInvalidScenarios
     */
    public function test_should_make_invalid_response(array $data, string $errorMessage): void
    {
        // Set
        $factory = new Factory();

        // Act
        $response = $factory->make($data);

        // Assert
        $this->assertInstanceOf(ErrorResponse::class, $response);
        $this->assertSame($errorMessage, $response->getErrorMessage());
    }

    /**
     * @dataProvider getValidScenarios
     */
    public function test_should_make_response(string $fixturePath, int $expectedCount): void
    {
        // Set
        $factory = new Factory();
        $data = $this->getJsonFixture($fixturePath);

        // Act
        $response = $factory->make($data);

        // Assert
        $this->assertInstanceOf(PurchaseInvoicesResponse::class, $response);
        $this->assertSame($expectedCount, count($response->data()));
    }

    public function getInvalidScenarios(): array
    {
        return [
            'data is empty' => [
                'data' => [],
                'errorMessage' => 'Invalid response!',
            ],
            'data with error' => [
                'data' => [
                    'error' => 'Invalid call to the API',
                ],
                'errorMessage' => 'Invalid call to the API',
            ],
        ];
    }

    public function getValidScenarios(): array
    {
        return [
            'when data is from purchase invoices' => [
                'fixturePath' => 'Bling/Invoices/PurchaseInvoices/list-purchase-invoices-sanitized.json',
                'expectedCount' => 3,
            ],
            'when data is from sales invoices' => [
                'fixturePath' => 'Bling/Invoices/list-invoices-sanitized.json',
                'expectedCount' => 0,
            ],
        ];
    }
}
