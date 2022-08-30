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
            'sku' => '1234',
            'category' => 'Carrinhos de Bebê',
            'dimensions' => '11 x 25 x 28 cm',
            'images' => [],
            'name' => 'Carrinho de Bebê',
            'quantity' => 10.0,
            'weight' => '0,300 kg',
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
