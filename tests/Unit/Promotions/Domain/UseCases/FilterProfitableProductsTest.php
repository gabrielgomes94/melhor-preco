<?php

namespace Tests\Promotinos\Unit\Domain\UseCases;

use Mockery;
use Money\Money;
use Src\Calculator\Domain\Models\Price\Contracts\Price as PriceCalculated;
use Src\Calculator\Domain\Services\Contracts\CalculatePost;
use Src\Math\Percentage;
use Src\Prices\Domain\Models\Price;
use Src\Promotions\Domain\UseCases\FilterProfitableProducts;
use Tests\Data\Marketplaces\MarketplaceData;
use Tests\Promotions\Data\TransferObjects\PromotionSetupData;
use Tests\TestCase;

class FilterProfitableProductsTest extends TestCase
{
    public function test_should_get_empty_filter_when_prices_are_not_profitable(): void
    {
        // Set
        $calculatePost = Mockery::mock(CalculatePost::class);
        $calculatedPrice = Mockery::mock(PriceCalculated::class);
        $filterprofitableProducts = new FilterProfitableProducts($calculatePost);

        // Expect
        $calculatePost->expects()
            ->calculatePost(
                Mockery::type(Price::class),
                ['discountRate' => Percentage::fromFraction(5)]
            )
            ->andReturn($calculatedPrice);

        $calculatedPrice->expects()
            ->isProfitable()
            ->times(3)
            ->andReturnFalse();

        // Act
        $result = $filterprofitableProducts->get(
            MarketplaceData::createWithPrices(),
            PromotionSetupData::create()
        );

        // Assert
        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    public function test_should_get_empty_filter_when_prices_are_profitable_but_margin_is_too_low(): void
    {
        // Set
        $calculatePost = Mockery::mock(CalculatePost::class);
        $calculatedPrice = Mockery::mock(PriceCalculated::class);
        $filterprofitableProducts = new FilterProfitableProducts($calculatePost);

        // Expect
        $calculatePost->expects()
            ->calculatePost(
                Mockery::type(Price::class),
                ['discountRate' => Percentage::fromFraction(5)]
            )
            ->andReturn($calculatedPrice);

        $calculatedPrice->expects()
            ->isProfitable()
            ->times(3)
            ->andReturnTrue();

        $calculatedPrice->expects()
            ->getMargin()
            ->times(3)
            ->andReturn(3);

        // Act
        $result = $filterprofitableProducts->get(
            MarketplaceData::createWithPrices(),
            PromotionSetupData::create()
        );

        // Assert
        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    public function test_should_get_filter(): void
    {
        // Set
        $calculatePost = Mockery::mock(CalculatePost::class);
        $calculatedPrice = Mockery::mock(PriceCalculated::class);
        $filterprofitableProducts = new FilterProfitableProducts($calculatePost);

        // Expect
        $calculatePost->expects()
            ->calculatePost(
                Mockery::type(Price::class),
                ['discountRate' => Percentage::fromFraction(5)]
            )
            ->times(6)
            ->andReturn($calculatedPrice);

        $calculatedPrice->expects()
            ->isProfitable()
            ->times(3)
            ->andReturnTrue();

        $calculatedPrice->expects()
            ->getMargin()
            ->times(3)
            ->andReturn(10);

        $calculatedPrice->expects()
            ->get()
            ->times(3)
            ->andReturn(Money::BRL(100));

        $calculatedPrice->expects()
            ->getProfit()
            ->times(3)
            ->andReturn(Money::BRL(10));

        // Act
        $result = $filterprofitableProducts->get(
            MarketplaceData::createWithPrices(),
            PromotionSetupData::create()
        );

        // Assert
        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }
}
