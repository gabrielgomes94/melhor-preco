<?php

namespace Src\Products\Infrastructure\Laravel\Jobs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Src\Products\Infrastructure\Laravel\Services\SynchronizeProductCosts;
use Src\Products\Infrastructure\Laravel\Services\SynchronizeProducts as SynchronizeProductsService;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class SyncProductsTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_handle(): void
    {
        // Arrange
        $user = UserData::make();
        $job = new SyncProducts($user);
        $syncCostsService = Mockery::mock(SynchronizeProductCosts::class);
        $syncProductsService = Mockery::mock(SynchronizeProductsService::class);

        // Expects
        $syncProductsService->expects()
            ->sync($user)
            ->andReturn();

        $syncCostsService->expects()
            ->sync($user)
            ->andReturn();

        // Act
        $job->handle(
            $syncCostsService,
            $syncProductsService
        );

    }
}
