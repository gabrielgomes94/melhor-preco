<?php

namespace Tests\Feature\Front\Products;

use App\Models\Product as ProductModel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\Data\Models\Product\Contracts\ProductFactory;
use Tests\Data\Models\ProductDataFactory;
use Tests\TestCase;

class CostsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_render_edit_page(): void
    {
        // Set
        $user = User::factory()->create();
        ProductDataFactory::createCollection([
            ['id' => '1234'],
            ['id' => '1235'],
        ]);

        $products = [
            ProductModel::find('1234')->toDomainObject(),
            ProductModel::find('1235')->toDomainObject(),
        ];
        $paginator = new LengthAwarePaginator($products,2, 40, 1, [
                'path' => 'http://localhost/products/costs/edit',
                'query' => [],
            ]
        );

        // Actions
        $response = $this
            ->actingAs($user)
            ->get('/products/costs/edit');

        // Assertions
        $response->assertStatus(200);
        $response->assertViewIs('pages.products.price_costs.edit');
        $response->assertViewHas('products', $products);
        $response->assertViewHas('paginator', $paginator);
    }

    public function test_should_render_edit_page_when_searching_by_sku(): void
    {
        // Set
        $user = User::factory()->create();
        ProductDataFactory::createCollection([
            ['id' => '1234'],
        ]);

        $products = [ProductModel::find('1234')->toDomainObject()];
        $paginator = new LengthAwarePaginator($products,1, 40, 1, [
                'path' => 'http://localhost/products/costs/edit',
                'query' => ['sku' => '1234'],
            ]
        );

        // Actions
        $response = $this
            ->actingAs($user)
            ->get('/products/costs/edit?sku=1234');

        // Assertions
        $response->assertStatus(200);
        $response->assertViewIs('pages.products.price_costs.edit');
        $response->assertViewHas('products', $products);
        $response->assertViewHas('paginator', $paginator);
    }

    public function test_should_render_edit_page_when_not_find_any_sku(): void
    {
        // Set
        $user = User::factory()->create();
        ProductDataFactory::createCollection();

        $products = [];
        $paginator = new LengthAwarePaginator($products,0, 40, 1, [
                'path' => 'http://localhost/products/costs/edit',
                'query' => ['sku' => '1234'],
            ]
        );

        // Actions
        $response = $this
            ->actingAs($user)
            ->get('/products/costs/edit?sku=1234');

        // Assertions
        $response->assertStatus(200);
        $response->assertViewIs('pages.products.price_costs.edit');
        $response->assertViewHas('products', $products);
        $response->assertViewHas('paginator', $paginator);
    }

    public function test_should_render_edit_page_with_variation_products(): void
    {
        // Set
        $user = User::factory()->create();
        ProductDataFactory::createCollection([
            [
                'id' => '0001',
                'variations' => ['1234', '1235'],
            ],
        ],ProductFactory::WITH_VARIATIONS);

        $products = [
            ProductModel::find('0001')->toDomainObject(),
        ];

        // Actions
        $response = $this
            ->actingAs($user)
            ->get('/products/costs/edit');

        // Assertions
        $response->assertStatus(200);
        $response->assertViewIs('pages.products.price_costs.edit');
        $response->assertViewHas('products', $products);
    }

    public function test_should_update_costs(): void
    {
        // Set
        $user = User::factory()->create();
        ProductDataFactory::createCollection([
            ['id' => '1234'],
        ]);

        $input = [
            'purchasePrice' => 500.0,
            'taxICMS' => 6.0,
            'additionalCosts' => 1.5,
        ];

        // Actions
        $response = $this
            ->actingAs($user)
            ->put('/products/costs/price_cost/update/1234', $input);

        // Assertions
        $response->assertStatus(302);
        $response->assertSessionHas('message', 'Produto 1234 teve seu custo atualizado com sucesso.');
    }

    public function test_should_not_update_costs(): void
    {
        // Set
        $user = User::factory()->create();

        $input = [
            'purchasePrice' => 500.0,
            'taxICMS' => 6.0,
            'additionalCosts' => 1.5,
        ];

        // Actions
        $response = $this
            ->actingAs($user)
            ->put('/products/costs/price_cost/update/1234', $input);

        // Assertions
        $response->assertStatus(302);
        $response->assertSessionHas('error', 'Produto não foi encontrado no banco de dados.');
    }
}
