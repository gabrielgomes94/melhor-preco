<?php

namespace Tests\Unit\Costs\Infrastructure\Laravel\Presenters;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Src\Costs\Infrastructure\Laravel\Presenters\ListProductCostsPresenter;
use Src\Products\Domain\DataTransfer\FilterOptions;
use Src\Users\Infrastructure\Laravel\Models\User;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class ListProductCostsPresenterTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_present_list_of_product_costs(): void
    {
        // Arrange
        $presenter = new ListProductCostsPresenter();
        $user = UserData::persisted();

        // Act
        $result = $presenter->present(
            $this->getPaginator($user),
            new FilterOptions(sku: 1)
        );

        // Assert
        $expected = [
            'products' => $this->getProductsList($user),
            'paginator' => $this->getPaginator($user),
            'filter'=> [
                'sku' => 1,
            ],
        ];

        $this->assertEquals($expected, $result);
    }

    private function getProductsList(User $user): array
    {
        return [
            ProductData::babyChair($user),
            ProductData::babyCarriage($user),
            ProductData::babyPacifier($user),
            ProductData::redBlanket($user),
            ProductData::cradle($user),
        ];
    }

    private function getPaginator(User $user): Paginator
    {
        return new LengthAwarePaginator($this->getProductsList($user), 100, 2);
    }
}
