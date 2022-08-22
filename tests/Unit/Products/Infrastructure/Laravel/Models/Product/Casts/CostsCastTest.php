<?php

namespace Src\Products\Infrastructure\Laravel\Models\Product\Casts;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Products\Domain\Models\ValueObjects\Costs;
use Src\Products\Domain\Models\ValueObjects\Dimensions;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class CostsCastTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_get(): void
    {
        // Arrange
        $user = UserData::make();
        $product = ProductData::babyCarriage($user);
        $cast = new CostsCast();

        // Act
        $result = $cast->get($product, 'costs', null, []);

        // Assert
        $this->assertInstanceOf(Costs::class, $result);

        $costs = new Costs(449.9, 0.0, 12.0);
        $this->assertEquals($costs, $result);
    }

    public function test_should_not_get(): void
    {
        // Arrange
        $user = UserData::make();
        $cast = new CostsCast();

        // Expects
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('Invalid type for model parameter');

        // Act
        $cast->get($user, 'costs', null, []);
    }

    public function test_should_set(): void
    {
        // Arrange
        $user = UserData::make();
        $product = ProductData::babyCarriage($user);
        $cast = new CostsCast();

        $costs = new Costs(529.49, 15.9, 12.0);
        $expected = [
            'purchase_price' => 529.49,
            'additional_costs' => 15.9,
            'tax_icms' => 12.0,
        ];

        // Act
        $result = $cast->set($product, 'costs', $costs, []);

        // Assert
        $this->assertSame($expected, $result);
    }

    public function test_should_not_set(): void
    {
        // Arrange
        $user = UserData::make();
        $cast = new CostsCast();

        // Expects
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('Invalid type for value parameter');

        // Act
        $cast->set($user, 'costs', null, []);
    }
}
