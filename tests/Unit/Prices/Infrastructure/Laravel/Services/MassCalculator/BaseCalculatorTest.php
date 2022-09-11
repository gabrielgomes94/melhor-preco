<?php

namespace Src\Prices\Infrastructure\Laravel\Services\MassCalculator;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Marketplaces\Infrastructure\Laravel\Repositories\CommissionRepository;
use Src\Marketplaces\Infrastructure\Laravel\Repositories\FreightRepository;
use Src\Prices\Domain\Models\Calculator\CalculatedPrice;
use Src\Prices\Infrastructure\Laravel\Models\Price;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Prices\PriceData;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class BaseCalculatorTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_calculate(): void
    {
        // Arrange
        $instance = $this->getCalculator();

        $user = UserData::make();
        $marketplace = MarketplaceData::shopee($user);
        ProductData::babyCarriage($user, [
            $price = PriceData::build($marketplace, ['value' => 899.9])
        ]);

        // Act
        $result = $instance->get($price);

        // Assert
        $this->assertSame(1000.00, $result->get());
        $this->assertSame(100.00, $result->getCommission());
        $this->assertSame(358.2, $result->getProfit());
        $this->assertSame(0.0, $result->getFreight());
    }

    private function getCalculator(): BaseCalculator
    {
        $commissionRepository = new CommissionRepository();
        $freightRepository = new FreightRepository();

        return new class ($commissionRepository, $freightRepository) extends BaseCalculator {
            public function get(Price $price): CalculatedPrice {
                return $this->calculate($price, 1000.0);
            }
        };
    }
}
