<?php

namespace Src\Promotions\Domain\UseCases;

use Mockery;
use Src\Marketplaces\Application\Exceptions\MarketplaceNotFoundException;
use Src\Marketplaces\Application\Models\Marketplace;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Promotions\Domain\Repositories\PromotionRepository;
use Src\Promotions\Domain\UseCases\Contracts\FilterProfitableProducts;
use Tests\Data\Promotions\Entities\PromotionData;
use Tests\Data\Promotions\TransferObjects\PromotionSetupData;
use Tests\Prices\Data\PriceData;
use Tests\TestCase;

class UpdatePromotionTest extends TestCase
{
    public function test_should_throw_exception_when_marketplace_is_not_found(): void
    {
        // Set
        $marketplaceRepository = Mockery::mock(MarketplaceRepository::class);
        $promotionRepository = Mockery::mock(PromotionRepository::class);
        $filterProfitableProducts = Mockery::mock(FilterProfitableProducts::class);

        $updatePromotions = new UpdatePromotion(
            $marketplaceRepository,
            $promotionRepository,
            $filterProfitableProducts
        );

        $promotionSetupData = PromotionSetupData::create();
        $uuid = '1123-3213-1234-1231';

        // Expectations
        $marketplaceRepository->expects()
            ->getBySlug('zxcv-store')
            ->andReturnNull();

        $this->expectException(MarketplaceNotFoundException::class);

        // Act
        $updatePromotions->update($uuid, $promotionSetupData);
    }

    public function test_should_update_promotion(): void
    {
        // Set
        $marketplaceRepository = Mockery::mock(MarketplaceRepository::class);
        $promotionRepository = Mockery::mock(PromotionRepository::class);
        $filterProfitableProducts = Mockery::mock(FilterProfitableProducts::class);

        $updatePromotions = new UpdatePromotion(
            $marketplaceRepository,
            $promotionRepository,
            $filterProfitableProducts
        );

        $promotionSetupData = PromotionSetupData::create();
        $uuid = '1123-3213-1234-1231';
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
            ->update($uuid, $promotionSetupData, $prices)
            ->andReturn($promotion);

        // Act
        $result = $updatePromotions->update($uuid, $promotionSetupData);

        // Assert
        $this->assertSame($promotion, $result);
    }
}
