<?php

namespace Src\Prices\Infrastructure\Laravel\Presenters\PriceList;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Products\Infrastructure\Laravel\Repositories\CategoryRepository;
use Src\Products\Infrastructure\Laravel\Repositories\Options\Options;
use Tests\Data\Models\CategoryData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class FilterPresenterTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_present_filter(): void
    {
        // Arrange
        $presenter = new FilterPresenter(new CategoryRepository());
        $options = new Options(minimumProfit: 10.0, maximumProfit: 15.0, sku: '1234', userId: '1');

        $user = UserData::make();
        CategoryData::babyCarriage($user);
        CategoryData::babyChair($user);
        $expected = [
            'categories' => [
                1 => [
                    'name' => 'Cadeira de Bebê',
                    'category_id' => '11',
                ],
                0 => [
                    'name' => 'Carrinhos de Bebê',
                    'category_id' => '10',
                ],
            ],
            'minimumProfit' => 10.0,
            'maximumProfit' => 15.0,
            'sku' => '1234',
        ];

        // Act
        $result = $presenter->present($options);

        // Assert
        $this->assertSame($expected, $result);

    }
}
