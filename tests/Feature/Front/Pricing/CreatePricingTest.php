<?php

namespace Tests\Feature\Front\Pricing;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class CreatePricingTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->actingAs($user);
    }

    public function test_should_render_create_page(): void
    {
        // Act
        $response = $this->get('pricing/create');

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('pricing.create');
    }

    public function test_should_store_pricing(): void
    {
        // Set
        $this->setupProducts();

        $input = [
            'name' => 'Promoção com carrinhos de bebê',
            'stores' => ['magalu'],
            'skus' => '1220',
        ];

        // Act
        $response = $this->post('pricing/campaigns/store', $input);

        // Assert
        $response->assertStatus(302);
        $response->assertRedirect('pricing/');
        $this->assertDatabaseCount('pricing', 1);
    }

    public function test_should_not_store_pricing(): void
    {
        // Act
        $response = $this->post('pricing/campaigns/store', []);

        // Assert
        $response->assertStatus(302);
        $this->assertDatabaseCount('pricing', 0);
    }

    public function test_should_not_store_pricing_when_sku_list_is_invalid(): void
    {
        // Set
        $this->setupProducts();

        $input = [
            'name' => 'Promoção com carrinhos de bebê',
            'stores' => ['magalu'],
            'skus' => '',
        ];

        // Act
        $response = $this->post('pricing/campaigns/store', []);

        // Assert
        $response->assertStatus(302);
        $this->assertDatabaseCount('pricing', 0);
    }

    private function setupProducts(): void
    {
        $product = new Product([
            'sku' => '1220',
            'name' => 'Carrinho de Bebê de Teste',
            'purchase_price' => 500.0,
            'sku_magalu' => '9887512931890',
            'sku_b2w' => '890712378912',
            'sku_mercado_livre' => '6908125902',
            'tax_ipi' => 4.0,
            'tax_icms' => 16.0,
            'tax_simples_nacional' => 4.0,
        ]);

        $product->save();
    }
}
