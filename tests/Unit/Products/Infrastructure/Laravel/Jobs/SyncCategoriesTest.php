<?php

namespace Src\Products\Infrastructure\Laravel\Jobs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Src\Products\Domain\Services\SyncCategories as SyncCategoriesService;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class SyncCategoriesTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_handle(): void
    {
        // Arrange
        $user = UserData::make();
        $job = new SyncCategories($user);

        $service = Mockery::mock(SyncCategoriesService::class);

        // Expects
        $service->expects()
            ->sync($user)
            ->andReturn();

        // Act
        $job->handle($service);
    }
}
