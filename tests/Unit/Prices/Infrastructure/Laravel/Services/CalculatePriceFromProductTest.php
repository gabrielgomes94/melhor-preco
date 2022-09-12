<?php

namespace Src\Prices\Infrastructure\Laravel\Services;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Math\Percentage;
use Src\Prices\Domain\DataTransfer\CalculatorForm;
use Src\Prices\Domain\DataTransfer\PriceCalculatedFromProduct;
use Src\Prices\Domain\Exceptions\ProductHasNoPriceInMarketplace;
use Src\Prices\Domain\Models\Calculator\CostPrice;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Prices\PriceData;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class CalculatePriceFromProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_calculate_price_from_product_when_there_is_calculator_form(): void
    {
        // Arrange
        $user = UserData::make();
        $marketplace = MarketplaceData::shopee($user);
        $product = ProductData::babyCarriage(
            $user,
            [
                PriceData::build($marketplace, ['value' => 899.9]),
            ],
        );
        $calculatorForm = new CalculatorForm(
            1000.0,
            50.0,
            Percentage::fromPercentage(13),
            Percentage::fromPercentage(5),

        );

        $service = app(CalculatePriceFromProduct::class);

        // Act
        $result = $service->calculate($marketplace, $product, $calculatorForm);

        // Assert
        $this->assertInstanceOf(PriceCalculatedFromProduct::class, $result);
        $this->assertSame('1234', $result->product->getSku());
        $this->assertSame('shopee', $result->marketplace->getSlug());
        $this->assertSame(950.0, $result->calculatedPrice->get());
        $this->assertSame(123.5, $result->calculatedPrice->getCommission());
        $this->assertInstanceOf(CostPrice::class, $result->calculatedPrice->getCostPrice());
        $this->assertSame(712.58, $result->calculatedPrice->getCosts());
        $this->assertSame(37.41, $result->calculatedPrice->getDifferenceICMS());
        $this->assertSame(50.0, $result->calculatedPrice->getFreight());
        $this->assertSame(24.99, $result->calculatedPrice->getMargin());
        $this->assertSame(237.42, $result->calculatedPrice->getProfit());
        $this->assertSame(449.9, $result->calculatedPrice->getPurchasePrice());
        $this->assertSame(51.78, $result->calculatedPrice->getSimplesNacional());
        $this->assertTrue($result->calculatedPrice->isProfitable());
    }

    public function test_should_calculate_price_from_product_when_there_is_no_commission_in_calculator_form(): void
    {
        // Arrange
        $user = UserData::make();
        $marketplace = MarketplaceData::shopee($user);
        $product = ProductData::babyCarriage(
            $user,
            [
                PriceData::build($marketplace, ['value' => 899.9]),
            ],
        );
        $calculatorForm = new CalculatorForm(
            1000.0,
            50.0,
            null,
            Percentage::fromPercentage(5),

        );

        $service = app(CalculatePriceFromProduct::class);

        // Act
        $result = $service->calculate($marketplace, $product, $calculatorForm);
        $this->assertSame(950.0, $result->calculatedPrice->get());
        $this->assertSame(100.0, $result->calculatedPrice->getCommission());
        $this->assertSame(689.08, $result->calculatedPrice->getCosts());
    }


    public function test_should_not_calculate_price_when_product_has_no_price_in_marketplace(): void
    {
        // Arrange
        $user = UserData::make();
        $marketplace = MarketplaceData::shopee($user);
        $product = ProductData::babyCarriage($user);

        $service = app(CalculatePriceFromProduct::class);

        // Expect
        $this->expectException(ProductHasNoPriceInMarketplace::class);

        // Act
        $service->calculate($marketplace, $product);
    }

    public function test_should_calculate_price_from_product_when_there_is_no_calculator_form(): void
    {
        // Arrange
        $user = UserData::make();
        $marketplace = MarketplaceData::shopee($user);
        $product = ProductData::babyCarriage(
            $user,
            [
                PriceData::build($marketplace, ['value' => 899.9]),
            ],
        );

        $service = app(CalculatePriceFromProduct::class);

        // Act
        $result = $service->calculate($marketplace, $product);

        // Assert
        $this->assertInstanceOf(PriceCalculatedFromProduct::class, $result);
        $this->assertSame('1234', $result->product->getSku());
        $this->assertSame('shopee', $result->marketplace->getSlug());
        $this->assertSame(899.9, $result->calculatedPrice->get());
        $this->assertSame(100.0, $result->calculatedPrice->getCommission());
        $this->assertInstanceOf(CostPrice::class, $result->calculatedPrice->getCostPrice());
        $this->assertSame(636.34, $result->calculatedPrice->getCosts());
        $this->assertSame(37.41, $result->calculatedPrice->getDifferenceICMS());
        $this->assertSame(0.0, $result->calculatedPrice->getFreight());
        $this->assertSame(29.29, $result->calculatedPrice->getMargin());
        $this->assertSame(263.56, $result->calculatedPrice->getProfit());
        $this->assertSame(449.9, $result->calculatedPrice->getPurchasePrice());
        $this->assertSame(49.04, $result->calculatedPrice->getSimplesNacional());
        $this->assertTrue($result->calculatedPrice->isProfitable());
    }
}
