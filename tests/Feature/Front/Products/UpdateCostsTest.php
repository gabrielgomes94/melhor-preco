<?php

namespace Tests\Feature\Front\Products;

use App\Models\User;
use Tests\TestCase;

class UpdateCostsTest extends TestCase
{
    public function test_should_render_edit_page(): void
    {
        // Set
        $user = User::factory()->create();

        // Actions
        $response = $this
            ->actingAs($user)
            ->get('/products/costs/edit');

        // Assertions
        $response->assertStatus(200);
        $response->assertViewIs('pages.products.price_costs.edit');
        $response->assertViewHas([
            'paginator' => '',
            'product' => '',
            'sku' => null,
        ]);
    }

    public function test_should_update_costs(): void
    {}

    public function test_should_not_update_costs(): void
    {}
}
