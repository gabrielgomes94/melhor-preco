<?php

namespace Src\Products\Infrastructure\Laravel\Models\Product\Casts;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Products\Domain\Models\ValueObjects\Dimensions;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class DimensionsCastTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_get(): void
    {
        // Arrange
        $user = UserData::persisted();
        $product = ProductData::babyCarriage($user);
        $cast = new DimensionsCast();

        // Act
        $result = $cast->get($product, 'dimensions', null, []);

        // Assert
        $this->assertInstanceOf(Dimensions::class, $result);

        $dimensions = new Dimensions(11.0, 25.0, 28.0, 0.3);
        $this->assertEquals($dimensions, $result);
    }

    public function test_should_not_get(): void
    {
        // Arrange
        $user = UserData::persisted();
        $cast = new DimensionsCast();

        // Expects
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('Invalid type for model parameter');

        // Act
        $cast->get($user, 'dimensions', null, []);
    }

    public function test_should_set(): void
    {
        // Arrange
        $user = UserData::persisted();
        $product = ProductData::babyCarriage($user);
        $cast = new DimensionsCast();
        $dimensions = new Dimensions(15.0, 28.0, 20.0, 0.75);
        $expected = [
            'depth' => 15.0,
            'height' => 28.0,
            'width' => 20.0,
            'weight' => 0.75,
        ];

        // Act
        $result = $cast->set($product, 'dimensions', $dimensions, []);

        // Assert
        $this->assertSame($expected, $result);
    }

    public function test_should_not_set(): void
    {
        // Arrange
        $user = UserData::persisted();
        $cast = new DimensionsCast();

        // Expects
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('Invalid type for value parameter');

        // Act
        $cast->set($user, 'dimensions', null, []);
    }
}
