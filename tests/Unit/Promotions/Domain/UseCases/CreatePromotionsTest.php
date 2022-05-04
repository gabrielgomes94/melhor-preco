<?php

namespace Src\Promotions\Domain\UseCases;

use Mockery;
use Src\Marketplaces\Application\Exceptions\MarketplaceNotFoundException;
use Src\Marketplaces\Application\Models\Marketplace;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Promotions\Domain\Repositories\PromotionRepository;
use Src\Promotions\Domain\UseCases\Contracts\FilterProfitableProducts;
use Tests\Prices\Data\PriceData;
use Tests\Data\Promotions\Entities\PromotionData;
use Tests\Data\Promotions\TransferObjects\PromotionSetupData;
use Tests\TestCase;

class CreatePromotionsTest extends TestCase
{
    public function test_should_throw_exception_when_marketplace_is_not_found(): void
    {
        // Set
        $marketplaceRepository = Mockery::mock(MarketplaceRepository::class);
        $promotionRepository = Mockery::mock(PromotionRepository::class);
        $filterProfitableProducts = Mockery::mock(FilterProfitableProducts::class);

        $createPromotions = new CreatePromotion(
            $marketplaceRepository,
            $promotionRepository,
            $filterProfitableProducts
        );

        $promotionSetupData = PromotionSetupData::create();

        // Expectations
        $marketplaceRepository->expects()
            ->getBySlug('zxcv-store')
            ->andReturnNull();

        $this->expectException(MarketplaceNotFoundException::class);

        // Act
        $createPromotions->calculate($promotionSetupData);
    }

    public function test_should_create_promotions(): void
    {
        // Set
        $marketplaceRepository = Mockery::mock(MarketplaceRepository::class);
        $promotionRepository = Mockery::mock(PromotionRepository::class);
        $filterProfitableProducts = Mockery::mock(FilterProfitableProducts::class);

        $createPromotions = new CreatePromotion(
            $marketplaceRepository,
            $promotionRepository,
            $filterProfitableProducts
        );

        $promotionSetupData = PromotionSetupData::create();
        $marketplace = Mockery::mock(Marketplace::class);
        $prices = [PriceData::create()];
        $promotion = PromotionData::create();

        // Expectations
        $marketplaceRepository->expects()
            ->getBySlug('zxcv-store')
            ->andReturn($marketplace);

        $filterProfitableProducts->expects()
            ->get($marketplace, $promotionSetupData)
            ->andReturn($prices);

        $promotionRepository->expects()
            ->create($promotionSetupData, $prices)
            ->andReturn($promotion);

        // Act
        $result = $createPromotions->calculate($promotionSetupData);

        // Assert
        $this->assertSame($promotion, $result);
    }
}
