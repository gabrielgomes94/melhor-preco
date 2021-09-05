<?php

namespace Tests\Feature\Front\Products\Costs;

use App\Jobs\Products\Spreadsheets\UploadICMS;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UpdateICMSControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_render_upload_imcs_page(): void
    {
        // Set
        $user = User::factory()->create();

        // Actions
        $response = $this
            ->actingAs($user)
            ->get('/products/update_icms');

        // Assertions
        $response->assertStatus(200);
        $response->assertViewIs('pages.products.costs.upload_icms');
    }

    public function test_should_upload_icms_spreadsheet(): void
    {
        // Set
        Queue::fake();
        Session::start();
        Storage::fake('public');
        $user = User::factory()->create();
        $file = UploadedFile::fake()->create(public_path('produtos.xlsx'));

        // Actions
        $response = $this
            ->actingAs($user)
            ->put('products/update_icms/spreadsheet', [
                'file' => $file,
                '_token' => csrf_token(),
            ]);

        // Assertions
        Storage::disk('public')->assertExists('spreadsheets/products/update_costs/produtos.xlsx');
        Queue::assertPushed(UploadICMS::class, 1);
        $response->assertStatus(200);
        $response->assertViewIs('pages.products.costs.upload_icms');
        $response->assertSessionHas('message', 'A planilha foi enviada com sucesso para ser processada. Em breve você receberá um email informando o resultado dessa operação.');
    }

    public function test_should_not_upload_icms_spreadsheet(): void
    {
        // Set
        Queue::fake();
        Session::start();
        Storage::fake('public');
        $user = User::factory()->create();
        $file = UploadedFile::fake()->create(public_path('produtos.pdf'));

        // Actions
        $response = $this
            ->actingAs($user)
            ->put('products/update_icms/spreadsheet', [
                'file' => $file,
                '_token' => csrf_token(),
            ]);

        // Assertions
        Storage::disk('public')->assertMissing('spreadsheets/products/update_costs/produtos.pdf');
        Queue::assertNotPushed(UploadICMS::class);
        $response->assertStatus(200);
        $response->assertViewIs('pages.products.costs.upload_icms');
        $response->assertSessionHas('error', 'É necessário enviar um arquivo .xlsx ou .csv.');
    }
}
