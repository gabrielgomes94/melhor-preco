<?php

namespace Tests\Feature\Front\Pricing\PriceList;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\Data\Product\Models\ProductData;
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
        $response->assertViewIs('pages.pricing.create');
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

        // Act
        $response = $this->post('pricing/campaigns/store', []);

        // Assert
        $response->assertStatus(302);
        $this->assertDatabaseCount('pricing', 0);
    }

    private function setupProducts(): void
    {
        ProductData::persisted();
    }
}
