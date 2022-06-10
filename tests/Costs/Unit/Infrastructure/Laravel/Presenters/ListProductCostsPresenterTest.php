<?php

namespace Tests\Costs\Unit\Infrastructure\Laravel\Presenters;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Src\Costs\Infrastructure\Laravel\Presenters\ListProductCostsPresenter;
use Src\Products\Application\Data\FilterOptions;
use Src\Products\Domain\DataTransfer\ProductsPaginated;
use Tests\Data\Models\Products\ProductData;
use Tests\TestCase;

class ListProductCostsPresenterTest extends TestCase
{
    public function test_should_present_list_of_product_costs(): void
    {
        // Arrange
        $presenter = new ListProductCostsPresenter();

        // Act
        $result = $presenter->present(
            new ProductsPaginated($this->getPaginator()),
            new FilterOptions(sku: 1)
        );

        // Assert
        $expected = [
            'products' => $this->getProductsList(),
            'paginator' => $this->getPaginator(),
            'filter'=> [
                'sku' => 1,
            ],
        ];

        $this->assertEquals($expected, $result);
    }

    private function getProductsList(): array
    {
        return [
            ProductData::make(),
            ProductData::make(),
            ProductData::make(),
            ProductData::make(),
            ProductData::make(),
        ];
    }

    private function getPaginator(): Paginator
    {
        return new LengthAwarePaginator($this->getProductsList(), 100, 2);
    }
}
