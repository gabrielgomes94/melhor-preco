<?php

namespace Src\Promotions\Domain\UseCases;

use Mockery;
use Src\Promotions\Domain\Repositories\PromotionRepository;
use Src\Promotions\Infrastructure\Laravel\Models\Promotion;
use Tests\Data\Promotions\Entities\PromotionData;
use Tests\TestCase;

class ListPromotionsTest extends TestCase
{
    public function test_should_list(): void
    {
        // Set
        $promotionRepository = Mockery::mock(PromotionRepository::class);
        $listPromotions = new ListPromotions($promotionRepository);

        $expected = [
            PromotionData::create(),
            PromotionData::create([
                'name' => 'Promoção de Teste 2',
            ]),
            PromotionData::create([
                'name' => 'Promoção de Teste 3',
            ]),
        ];

        // Expect
        $promotionRepository->expects()
            ->list()
            ->andReturn($expected);

        // Act
        $result = $listPromotions->list();

        // Assert
        $this->assertContainsOnlyInstancesOf(Promotion::class, $result);
    }
}
