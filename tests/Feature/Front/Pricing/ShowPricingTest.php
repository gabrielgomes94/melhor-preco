<?php

namespace Tests\Feature\Front\Pricing;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowPricingTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->actingAs($user);
    }

    public function test_should_not_render_show_pricing_page(): void
    {
        // Act
        $response = $this->get('pricing/xpto');

        // Assert
        $response->assertStatus(404);
    }

    private function setupProduct(): string
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

        return $product->id;
    }
}
