<?php

namespace Src\Users\Infrastructure\Laravel\Providers;

use Src\Users\Domain\Repositories\Repository as RepositoryInterface;
use Src\Users\Domain\Services\SynchronizeData;
use Src\Users\Infrastructure\Laravel\Repositories\Repository;
use Tests\TestCase;

class UsersServiceProviderTest extends TestCase
{
    public function test_should_bind_through_users_service_provider(): void
    {
        // Act
        $repository = $this->app->make(RepositoryInterface::class);
        $synchronizeData = $this->app->make(SynchronizeData::class);

        // Assert
        $this->assertInstanceOf(Repository::class, $repository);
        $this->assertInstanceOf(SynchronizeData::class, $synchronizeData);
    }
}
