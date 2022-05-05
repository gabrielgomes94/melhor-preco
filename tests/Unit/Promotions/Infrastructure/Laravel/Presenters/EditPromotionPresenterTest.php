<?php

namespace Src\Promotions\Infrastructure\Laravel\Presenters;

use Tests\Data\Promotions\Entities\PromotionData;

class EditPromotionPresenterTest extends \Tests\TestCase
{
    public function test_should_present(): void
    {
        // Set
        $promotion = PromotionData::create();
        $presenter = new EditPromotionPresenter();

        $expected = [
            'name' => 'Promoção de Teste',
            'beginDate' => '01/01/2021',
            'endDate' => '31/01/2021',
            'discount' => 5.0,
            'uuid' => 'c376d5f0-c601-4ca0-98c7-378aa6d7e94d',
            'maxProductsLimit' => 100,
            'marketplaceSubsidy' => 0.0,
        ];

        // Act
        $result = $presenter->present($promotion);

        // Assert
        $this->assertSame($expected, $result);
    }
}
