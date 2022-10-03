<?php

namespace Src\Costs\Infrastructure\Laravel\Services;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery as m;
use Src\Costs\Infrastructure\Laravel\Services\SynchronizePurchaseInvoices;
use Src\Costs\Infrastructure\Bling\BlingRepository;
use Src\Costs\Infrastructure\Laravel\Models\PurchaseInvoice;
use Src\Costs\Infrastructure\Laravel\Repositories\Repository;
use Src\Users\Domain\Repositories\Repository as UserRepository;
use Src\Users\Infrastructure\Laravel\Models\User;
use Tests\Data\Models\Costs\PurchaseInvoiceData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class SynchronizePurchaseInvoicesTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_sync(): void
    {
        // Arrange
        $dbRepository = m::mock(Repository::class);
        $erpRepository = m::mock(BlingRepository::class);
        $userRepository = m::mock(UserRepository::class);
        $synchronizePurchaseInvoices = new SynchronizePurchaseInvoices($dbRepository, $erpRepository, $userRepository);

        $user = UserData::persisted();

        $purchaseInvoicesFromERP = [
            PurchaseInvoiceData::make(),
            PurchaseInvoiceData::make([
                'number' => '248285',
                'value' => 900.0,
            ]),
            PurchaseInvoiceData::make([
                'number' => '248286',
                'value' => 1800.0,
            ]),
        ];

        // Expects
        $userRepository->expects()
            ->find($user->getId())
            ->andReturn($user);


        $erpRepository->expects()
            ->listPurchaseInvoice('token')
            ->andReturn($purchaseInvoicesFromERP);

        $dbRepository->expects()
            ->insertPurchaseInvoice(m::type(PurchaseInvoice::class), m::type('string'))
            ->times(3)
            ->andReturnTrue();

        // Act
        $synchronizePurchaseInvoices->sync($user->getId());
    }
}
