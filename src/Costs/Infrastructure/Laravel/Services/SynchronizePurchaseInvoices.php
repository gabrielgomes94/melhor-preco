<?php

namespace Src\Costs\Infrastructure\Laravel\Services;

use Src\Costs\Domain\Repositories\DbRepository;
use Src\Costs\Domain\Repositories\ErpRepository;
use Src\Costs\Domain\Services\SyncPurchaseInvoices;
use Src\Users\Domain\Repositories\Repository as UserRepository;

class SynchronizePurchaseInvoices implements SyncPurchaseInvoices
{
    public function __construct(
        private readonly DbRepository $repository,
        private readonly ErpRepository $erpRepository,
        private readonly UserRepository $userRepository
    )
    {
    }

    public function sync(string $userId): void
    {
        $user = $this->userRepository->find($userId);

        if (!$user) {
            return;
        }

        $data = $this->erpRepository->listPurchaseInvoice($user->getErpToken());

        foreach ($data as $purchaseInvoice) {
            $this->repository->insertPurchaseInvoice($purchaseInvoice, $userId);
        }
    }
}
