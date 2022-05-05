<?php

namespace Tests\Legacy\Feature\Front\Products\Reports;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Data\Models\ProductDataFactory;
use Tests\TestCase;

class DimensionsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_render_page_listing_products_with_over_dimensions(): void
    {
        // Set
        $user = User::factory()->create();
        ProductDataFactory::createCollection([
            [
                'id' => '1234',
                'depth' => 100,
                'height' => 100,
                'width' => 100,
            ],
            [
                'id' => '1235',
                'depth' => 80,
                'height' => 40,
                'width' => 60,
            ],
        ]);

        $products = [
            Product::find('1234')->toDomainObject(),
        ];

        // Actions
        $response = $this
            ->actingAs($user)
            ->get('/products/reports/over_dimension');

        // Assertions
        $response->assertStatus(200);
        $response->assertViewIs('pages.products.reports.over_dimension');
        $response->assertViewHas('overDimensionProducts', $products);
    }
}
