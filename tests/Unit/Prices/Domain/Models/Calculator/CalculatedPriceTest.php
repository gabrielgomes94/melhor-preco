<?php

namespace Src\Prices\Domain\Models\Calculator;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Math\Percentage;
use Src\Prices\Domain\DataTransfer\CalculatorForm;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class CalculatedPriceTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_make_instance_from_product(): void
    {
        // Arrange
        $user = UserData::make();
        $product = ProductData::babyCarriage($user);
        $calculatorForm = new CalculatorForm(
            1000.0,
            20.25,
            Percentage::fromPercentage(8.0),
            Percentage::fromPercentage(0.0),
        );

        // Act
        $instance = CalculatedPrice::fromProduct($product, 80.0, $calculatorForm);

        // Assert
        $this->assertSame(1000.0, $instance->get());
        $this->assertSame(80.0, $instance->getCommission());

        $expectedCostPrice = new CostPrice(
            449.9,
            0.0,
            Percentage::fromPercentage(12),
            Percentage::fromPercentage(18),
            Percentage::fromPercentage(5.45),
        );
        $this->assertEquals($expectedCostPrice, $instance->getCostPrice());
        $this->assertSame(642.05, $instance->getCosts());
        $this->assertSame(37.41, $instance->getDifferenceICMS());
        $this->assertSame(20.25, $instance->getFreight());
        $this->assertSame(35.8, $instance->getMargin());
        $this->assertSame(357.95, $instance->getProfit());
        $this->assertSame(449.9, $instance->getPurchasePrice());
        $this->assertSame(54.5, $instance->getSimplesNacional());
        $this->assertTrue($instance->isProfitable());
    }
}
