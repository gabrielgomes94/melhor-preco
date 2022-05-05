<?php

namespace Tests\Legacy\Feature\Front\Products\StockTag;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Tests\TestCase;

class StockTagControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_render_create_qr_code_page(): void
    {
        // Set
        $user = User::factory()->create();

        // Actions
        $response = $this
            ->actingAs($user)
            ->get('/products/stock_tags/');

        // Assertions
        $response->assertStatus(200);
        $response->assertViewIs('pages.products.stock_tags.generate_qr_code');
    }

    public function test_should_generate_qr_codes(): void
    {
        // Set
        $user = User::factory()->create();
        $input = [
            'products' => [
                [
                    'sku' => '2907',
                    'stock' => '1',
                    'name' => 'Cadeirinha Recline Ssfety 1ST',
                ],
                [
                    'sku' => '2908',
                    'stock' => '2',
                    'name' => 'Cadeirinha Legacy Voyage Preto',
                ],
            ],
        ];

        $expected = [
            [
                'qrCode' => QrCode::generate('http://localhost/products/reports/show_info/2907'),
                'sku' => '2907',
                'stock' => '1',
                'name' => 'Cadeirinha Recline Ssfety 1ST',
            ],
            [
                'qrCode' => QrCode::generate('http://localhost/products/reports/show_info/2908'),
                'sku' => '2908',
                'stock' => '2',
                'name' => 'Cadeirinha Legacy Voyage Preto',
            ],
            [
                'qrCode' => QrCode::generate('http://localhost/products/reports/show_info/2908'),
                'sku' => '2908',
                'stock' => '2',
                'name' => 'Cadeirinha Legacy Voyage Preto',
            ],
        ];

        // Actions
        $response = $this
            ->actingAs($user)
            ->post('/products/stock_tags/generate', $input);

        // Assertions
        $response->assertStatus(200);
        $response->assertViewIs('pages.products.stock_tags.list');
        $response->assertViewHas('products', $expected);
    }
}
