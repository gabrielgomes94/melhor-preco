<?php

namespace Src\Prices\Infrastructure\Laravel\Services;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Prices\Domain\DataTransfer\MassCalculationTypes;
use Src\Prices\Domain\DataTransfer\MassCalculatorForm;
use Src\Users\Infrastructure\Laravel\Models\User;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Prices\PriceData;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class MassCalculatePricesTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    public function test_should_mass_calculate_prices_by_markup(): void
    {
        // Arrange
        $service = app(MassCalculatePrices::class);
        $user = UserData::make();
        $marketplace = MarketplaceData::shopee($user);
        $this->setProducts($marketplace, $user);

        $form = new MassCalculatorForm(2, MassCalculationTypes::Markup);

        // Act
        $result = $service->calculate($marketplace, $form);

        // Assert
        $this->assertCount(3, $result->calculatedPrices);
        $this->assertSame(974.6, $result->calculatedPrices[0]->calculatedPrice->get());
        $this->assertSame(214.46, $result->calculatedPrices[1]->calculatedPrice->get());
        $this->assertSame(14.62, $result->calculatedPrices[2]->calculatedPrice->get());
    }

    public function test_should_mass_calculate_prices_by_addition(): void
    {
        // Arrange
        $service = app(MassCalculatePrices::class);
        $user = UserData::make();
        $marketplace = MarketplaceData::shopee($user);
        $this->setProducts($marketplace, $user);

        $form = new MassCalculatorForm(15, MassCalculationTypes::Discount);

        // Act
        $result = $service->calculate($marketplace, $form);

        // Assert
        $this->assertCount(3, $result->calculatedPrices);
        $this->assertSame(764.92, $result->calculatedPrices[0]->calculatedPrice->get());
        $this->assertSame(594.91, $result->calculatedPrices[1]->calculatedPrice->get());
        $this->assertSame(16.91, $result->calculatedPrices[2]->calculatedPrice->get());
    }

    public function test_should_mass_calculate_prices_by_discount(): void
    {
        // Arrange
        $service = app(MassCalculatePrices::class);
        $user = UserData::make();
        $marketplace = MarketplaceData::shopee($user);
        $this->setProducts($marketplace, $user);

        $form = new MassCalculatorForm(5, MassCalculationTypes::Addition);

        // Act
        $result = $service->calculate($marketplace, $form);

        // Assert
        $this->assertCount(3, $result->calculatedPrices);
        $this->assertSame(944.9, $result->calculatedPrices[0]->calculatedPrice->get());
        $this->assertSame(734.9, $result->calculatedPrices[1]->calculatedPrice->get());
        $this->assertSame(20.88, $result->calculatedPrices[2]->calculatedPrice->get());
    }

    private function setProducts(Marketplace $marketplace, User $user): void
    {
        ProductData::babyCarriage($user, [
            PriceData::build($marketplace, ['value' => 899.9])
        ]);
        ProductData::babyChair($user, [
            PriceData::build($marketplace, ['value' => 699.9])
        ]);
        ProductData::babyPacifier($user, [
            PriceData::build($marketplace, ['value' => 19.9])
        ]);
    }
}
