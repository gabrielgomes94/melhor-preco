<?php

namespace Tests\Feature\Front\Products\Synchronization;

use Src\Products\Application\Jobs\Spreadsheets\UploadICMS;
use Src\Products\Application\Jobs\SyncProducts;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class SynchronizationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_dispatch_command_to_synchronize_products(): void
    {
        // Set
        Queue::fake();
        $user = User::factory()->create();

        // Actions
        $response = $this
            ->actingAs($user)
            ->put('products/sync');

        // Assertions
        $response->assertStatus(200);
        Queue::assertPushed(SyncProducts::class, 1);
    }
}
