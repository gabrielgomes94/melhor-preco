<?php

namespace Src\Products\Infrastructure\Laravel\Models\Product\Casts;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Products\Domain\Models\ValueObjects\Composition;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class CompositionCastTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_get(): void
    {
        // Arrange
        $user = UserData::make();
        ProductData::cradle($user);
        ProductData::babyCarriage($user);
        $product = ProductData::kitCradleAndCarriage($user);
        $cast = new CompositionCast();

        // Act
        $result = $cast->get($product, 'composition', null, []);

        // Assert
        $this->assertInstanceOf(Composition::class, $result);
        $this->assertContainsOnlyInstancesOf(Product::class, $result->get());
        $this->assertSame(['589', '1234'], $result->getSkus());
    }

    public function test_should_not_get(): void
    {
        // Arrange
        $user = UserData::make();
        $cast = new CompositionCast();

        // Expects
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('Invalid type for model parameter');

        // Act
        $cast->get($user, 'composition', null, []);
    }

    public function test_should_set(): void
    {
        // Arrange
        $user = UserData::make();
        $product1 = ProductData::cradle($user);
        $product2 = ProductData::babyCarriage($user);
        $product = ProductData::kitCradleAndCarriage($user);
        $cast = new CompositionCast();

        $composition = new Composition([$product1, $product2]);
        $expected = [
            'composition_products' => ['589', '1234']
        ];

        // Act
        $result = $cast->set($product, 'composition', $composition, []);

        // Assert
        $this->assertSame($expected, $result);
    }

    public function test_should_not_set(): void
    {
        // Arrange
        $user = UserData::make();
        $cast = new CompositionCast();

        // Expects
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('Invalid type for value parameter');

        // Act
        $cast->set($user, 'composition', null, []);
    }
}
