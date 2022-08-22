<?php

namespace Src\Products\Domain\Models\ValueObjects;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class CompositionTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_instantiate_composition(): void
    {
        // Arrange
        $user = UserData::make();
        $products = [
            ProductData::babyChair($user),
            ProductData::babyCarriage($user),
        ];

        // Act
        $instance = new Composition($products);

        // Assert
        $this->assertTrue($instance->hasCompositions());
        $this->assertEquals($products, $instance->get());

        $expectedSkus = ['987', '1234'];
        $this->assertSame($expectedSkus, $instance->getSkus());

        $expectedCosts = new Costs(548.9, 0.0, 12);
        $this->assertEquals($expectedCosts, $instance->costs());
    }

    public function test_should_instantiate_empty_composition(): void
    {
        // Act
        $instance = new Composition([]);

        // Assert
        $this->assertFalse($instance->hasCompositions());
        $this->assertSame([], $instance->get());
        $this->assertSame([], $instance->getSkus());

        $expectedCosts = new Costs(0.0, 0.0, 0.0);
        $this->assertEquals($expectedCosts, $instance->costs());
    }
}
