<?php

namespace Src\Promotions\Infrastructure\Laravel\Presenters;

use Carbon\Carbon;
use Tests\Data\Promotions\Entities\PromotionData;
use Tests\TestCase;

class ListPromotionsPresenterTest extends TestCase
{
    public function test_should_present(): void
    {
        // Set
        $promotions = [
            PromotionData::create(),
            PromotionData::create([
                'name' => 'Liquidação 20% de desconto',
                'discount' => 20,
            ]),
            PromotionData::create([
                'name' => 'Promoção de Carrinhos',
                'discount' => 15,
                'begin_date' => Carbon::createFromFormat('d-m-Y', '01-02-2021'),
                'end_date' => Carbon::createFromFormat('d-m-Y', '28-02-2021'),
            ]),
        ];

        $presenter = new ListPromotionsPresenter();
        $expected = [
            [
                'name' => 'Promoção de Teste',
                'beginDate' => '01/01/2021',
                'endDate' => '31/01/2021',
                'discount' => 5.0,
                'uuid' => 'c376d5f0-c601-4ca0-98c7-378aa6d7e94d',
                'maxProductsLimit' => 100,
                'marketplaceSubsidy' => 0.0,
            ]
        ];

        // Act
        $result = $presenter->present($promotions);

        // Assert
        $this->assertSame($expected, $result);
    }

    public function test_should_handle_invalid_promotions(): void
    {

    }
}
