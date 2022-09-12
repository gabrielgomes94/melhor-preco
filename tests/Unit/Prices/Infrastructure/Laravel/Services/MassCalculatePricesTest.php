<?php

namespace Src\Prices\Infrastructure\Laravel\Services;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Prices\Domain\DataTransfer\ListPricesCalculated;
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

    private Marketplace $marketplace;
    private MassCalculatePrices $massCalculatePricesService;

    public function setUp(): void
    {
        parent::setUp();

        $this->massCalculatePricesService = app(MassCalculatePrices::class);

        $user = UserData::make();
        $this->marketplace = MarketplaceData::shopee($user);
        $this->setProducts($this->marketplace, $user);
    }

    public function test_should_mass_calculate_prices_by_markup(): void
    {
        // Arrange
        $form = new MassCalculatorForm(2, MassCalculationTypes::Markup);

        // Act
        $result = $this->massCalculatePricesService->calculate($this->marketplace, $form);

        // Assert
        $this->assertInstanceOf(ListPricesCalculated::class, $result);
        $this->assertCount(3, $result->calculatedPrices);
        $this->assertSame(974.6, $result->calculatedPrices[0]->calculatedPrice->get());
        $this->assertSame(214.46, $result->calculatedPrices[1]->calculatedPrice->get());
        $this->assertSame(14.62, $result->calculatedPrices[2]->calculatedPrice->get());
    }

    public function test_should_mass_calculate_prices_by_addition(): void
    {
        // Arrange
        $form = new MassCalculatorForm(15, MassCalculationTypes::Discount);

        // Act
        $result = $this->massCalculatePricesService->calculate($this->marketplace, $form);

        // Assert
        $this->assertInstanceOf(ListPricesCalculated::class, $result);
        $this->assertCount(3, $result->calculatedPrices);
        $this->assertSame(764.92, $result->calculatedPrices[0]->calculatedPrice->get());
        $this->assertSame(594.91, $result->calculatedPrices[1]->calculatedPrice->get());
        $this->assertSame(16.91, $result->calculatedPrices[2]->calculatedPrice->get());
    }

    public function test_should_mass_calculate_prices_by_discount(): void
    {
        // Arrange
        $form = new MassCalculatorForm(5, MassCalculationTypes::Addition);

        // Act
        $result = $this->massCalculatePricesService->calculate($this->marketplace, $form);

        // Assert
        $this->assertInstanceOf(ListPricesCalculated::class, $result);
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
