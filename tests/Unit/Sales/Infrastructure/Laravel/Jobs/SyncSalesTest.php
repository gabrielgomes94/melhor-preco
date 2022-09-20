<?php

namespace Src\Sales\Infrastructure\Laravel\Jobs;

use Mockery;
use PHPUnit\Framework\TestCase;
use Src\Sales\Infrastructure\Laravel\Services\SynchronizeSales;
use Src\Users\Domain\Repositories\Repository as UserRepository;
use Src\Users\Infrastructure\Laravel\Models\User;

class SyncSalesTest extends TestCase
{
    /**
     * @doesNotPerformAssertions
     */
    public function test_should_handle_sync_sales_job(): void
    {
        // Arrange
        $job = new SyncSales('1');

        $synchronizeService = Mockery::mock(SynchronizeSales::class);
        $userRepository = Mockery::mock(UserRepository::class);
        $user = Mockery::mock(User::class);

        // Expect
        $userRepository->expects()
            ->find('1')
            ->andReturn($user);

        $synchronizeService->expects()
            ->sync($user);

        // Act
        $job->handle($synchronizeService, $userRepository);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function test_should_handle_sync_sales_job_when_user_does_not_exists(): void
    {
        // Arrange
        $job = new SyncSales('1');

        $synchronizeService = Mockery::mock(SynchronizeSales::class);
        $userRepository = Mockery::mock(UserRepository::class);
        $user = Mockery::mock(User::class);

        // Expect
        $userRepository->expects()
            ->find('1')
            ->andReturnNull();

        // Act
        $job->handle($synchronizeService, $userRepository);
    }
}
