<?php

namespace Src\Products\Infrastructure\Laravel\Presenters;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Data\Models\CategoryData;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class ProductPresenterTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_present(): void
    {
        // Arrange
        $present = new ProductPresenter();
        $user = UserData::make();
        $category = CategoryData::babyCarriage($user);
        $product = ProductData::babyCarriage($user, [], $category);

        $expected = [
            'id' => '2',
            'sku' => '1234',
            'name' => 'Carrinho de Bebê',
            'purchase_price' => 449.90,
            'tax_icms' => 12.0,
            'additional_costs' => 0.00,
            'depth' => 11.00,
            'width' => 28.00,
            'height' => 25.00,
            'weight' => '0,300 kg',
            'erp_id' => '15865921214',
            'parent_sku' => null,
            'has_variations' => false,
            'composition_products' => [],
            'ean' => '7908238800092',
            'is_active' => true,
            'brand' => 'Galzerano',
            'images' => [],
            'category_id' => '10',
            'quantity' => 10.0,
            'user_id' => 2,
            'category' => 'Carrinhos de Bebê',
            'dimensions' => '11 x 25 x 28 cm',
        ];

        // Act
        $result = $present->present($product);

        // Assert
        $this->assertSame($expected, $result);
    }

    public function test_should_present_variation_product(): void
    {

    }
}
