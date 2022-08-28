<?php

namespace Src\Costs\Infrastructure\Laravel\Http\Controllers\Web;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Testing\TestResponse;
use Src\Costs\Infrastructure\Laravel\Jobs\SyncCosts;
use Src\Users\Infrastructure\Laravel\Models\User;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class SyncProductCostsTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_sync_costs(): void
    {
        // Arrange
        $user = UserData::make();
        $this->actingAs($user);
        $controller = new SyncController();
        Bus::fake();

        // Act
        $result = $controller->sync();

        // Assert
        Bus::assertDispatched(SyncCosts::class);
        $this->assertInstanceOf(RedirectResponse::class, $result);
    }
}
