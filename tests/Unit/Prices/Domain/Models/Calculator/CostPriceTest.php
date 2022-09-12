<?php

namespace Src\Prices\Domain\Models\Calculator;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class CostPriceTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_make_cost_price_from_product(): void
    {
        // Arrange
        $user = UserData::make();
        $product = ProductData::babyCarriage($user);

        // Act
        $instance = CostPrice::fromProduct($product);

        // Assert
        $this->assertSame(487.3, $instance->get());
        $this->assertSame(513.86, $instance->total());
        $this->assertSame(449.9, $instance->purchasePrice());
        $this->assertSame(37.41, $instance->differenceICMS());
        $this->assertSame(0.0545, $instance->simplesNacional());

    }
}
