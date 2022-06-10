<?php

namespace Tests\Costs\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Products\Domain\Models\Product\Product;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class ListProductsCostsTest extends TestCase
{
    use RefreshDatabase;

    public function test_shoud_list_products_costs(): void
    {
        // Set
        $user = UserData::make();
        $this->setProducts();

        $products = [
            Product::find('1'),
            Product::find('2'),
            Product::find('3'),
            Product::find('4'),
            Product::find('5'),
        ];

        // Act
        $response = $this
            ->actingAs($user)
            ->get('/custos/produtos/lista');

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('pages.costs.products.list');
        $response->assertViewHas('products', $products);
        $response->assertViewHas('paginator');
        $response->assertViewHas('filter', ['sku' => null]);
    }

    public function test_should_list_products_costs_when_filtering_by_sku(): void
    {
        // Set
        $user = UserData::make();
        $this->setProducts();

        $products = [
            Product::find('1'),
            Product::find('2'),
            Product::find('3'),
        ];

        // Act
        $response = $this
            ->actingAs($user)
            ->get('/custos/produtos/lista?sku=1');

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('pages.costs.products.list');
        $response->assertViewHas('products', $products);
        $response->assertViewHas('paginator');
        $response->assertViewHas('filter', ['sku' => 1]);
    }

    private function setProducts(): void
    {
        ProductData::makePersisted(['sku' => 1]);
        ProductData::makePersisted(['sku' => 2, 'parent_sku' => 1]);
        ProductData::makePersisted(['sku' => 3, 'composition_products' => [1, 2]]);
        ProductData::makePersisted(['sku' => 4]);
        ProductData::makePersisted(['sku' => 5]);
    }
}
