<?php

namespace Src\Products\Infrastructure\Laravel\Models\Product\Casts;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Products\Domain\Models\ValueObjects\Dimensions;
use Src\Products\Domain\Models\ValueObjects\Variations;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class VariationsCastTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_get_when_there_is_no_variations(): void
    {
        // Arrange
        $user = UserData::make();
        $product = ProductData::babyCarriage($user);
        $cast = new VariationsCast();

        // Act
        $result = $cast->get($product, 'variations', null, []);

        // Assert
        $this->assertInstanceOf(Variations::class, $result);

        $variations = new Variations();
        $this->assertEquals($variations, $result);
    }

    public function test_should_get_when_product_is_variation(): void
    {
        // Arrange
        $user = UserData::make();
        ProductData::blanket($user);
        $redProduct = ProductData::redBlanket($user);
        ProductData::blueBlanket($user);
        $cast = new VariationsCast();

        // Act
        $result = $cast->get($redProduct, 'variations', null, []);

        // Assert
        $this->assertInstanceOf(Variations::class, $result);
        $this->assertContainsOnlyInstancesOf(Product::class, $result->get());
        $this->assertNotEmpty($result->get());
        $this->assertSame('821', $result->getParentSku());
    }

    public function test_should_get_when_product_has_variation(): void
    {
        // Arrange
        $user = UserData::make();
        $product = ProductData::blanket($user);
        ProductData::redBlanket($user);
        ProductData::blueBlanket($user);
        $cast = new VariationsCast();

        // Act
        $result = $cast->get($product, 'variations', null, []);

        // Assert
        $this->assertInstanceOf(Variations::class, $result);
        $this->assertContainsOnlyInstancesOf(Product::class, $result->get());
        $this->assertNotEmpty($result->get());
        $this->assertSame('821', $result->getParentSku());
    }

    public function test_should_not_get(): void
    {
        // Arrange
        $user = UserData::make();
        $cast = new VariationsCast();

        // Expects
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('Invalid type for model parameter');

        // Act
        $cast->get($user, 'variations', null, []);
    }

    public function test_should_set(): void
    {
        // Arrange
        $user = UserData::make();
        $product = ProductData::blanket($user);
        $redProduct = ProductData::redBlanket($user);
        $blueProduct = ProductData::blueBlanket($user);
        $cast = new VariationsCast();
        $variations = new Variations('821', [
            $redProduct,
            $blueProduct,
        ]);

        $expected = [
            'parent_sku' => '821',
            'has_variations' => true,
        ];

        // Act
        $result = $cast->set($product, 'variations', $variations, []);

        // Assert
        $this->assertSame($expected, $result);
    }

    public function test_should_not_set(): void
    {
        // Arrange
        $user = UserData::make();
        $product = ProductData::blanket($user);
        $cast = new VariationsCast();

        // Expects
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('Invalid type for value parameter');

        // Act
        $cast->set($product, 'variations', $user, []);
    }
}
