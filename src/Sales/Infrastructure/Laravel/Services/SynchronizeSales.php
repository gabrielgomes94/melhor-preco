<?php

namespace Src\Sales\Infrastructure\Laravel\Services;

use Exception;
use Src\Sales\Domain\Events\SaleOrderWasNotSynchronized;
use Src\Sales\Domain\Factories\SaleOrder as SaleOrderFactory;
use Src\Sales\Domain\Models\Contracts\SaleOrder as SaleOrderInterface;
use Src\Sales\Domain\Models\SaleOrder;
use Src\Sales\Domain\Repositories\ErpRepository;
use Src\Sales\Domain\Repositories\Contracts\ItemsRepository;
use Src\Sales\Domain\Repositories\Contracts\SynchronizationRepository;
use Src\Sales\Domain\Repositories\Contracts\Repository;
use Src\Sales\Domain\Repositories\SaleOrderRepository as SaleOrderRepositoryInterface;
use Src\Sales\Infrastructure\Laravel\Services\CalculateTotalProfit;
use Src\Users\Domain\Repositories\Repository as UserRepository;

class SynchronizeSales
{
    public function __construct(
        private readonly CalculateTotalProfit         $calculateTotalProfit,
        private readonly ErpRepository                $erpRepository,
        private readonly SaleOrderRepositoryInterface $saleOrderRepository,
        private readonly UserRepository $userRepository
    ) {
    }

    public function sync(string $userId)
    {
        $user = $this->userRepository->find($userId);
        if (!$user) {
            return;
        }

        $data = $this->erpRepository->list($user->getErpToken());

        foreach ($data as $saleOrder) {
            try {
                if (!$saleOrderModel = $this->getSaleOrder($saleOrder)) {
                    $this->insertSaleOrder($saleOrder, $userId);

                    continue;
                }

                $this->updateSaleOrder($saleOrderModel, $saleOrder, $userId);
            } catch (Exception $exception) {
                event(new SaleOrderWasNotSynchronized($exception));
            }
        }
    }

    private function getSaleOrder(SaleOrderInterface $saleOrder): ?SaleOrder
    {
        $id = $saleOrder->getIdentifiers()->id();

        return SaleOrder::where('sale_order_id', $id)->first();
    }

    private function insertSaleOrder(SaleOrderInterface $externalSaleOrder, string $userId): void
    {
        $internalSaleOrder = SaleOrderFactory::makeModel($externalSaleOrder);
        $internalSaleOrder->user_id = $userId;
        $internalSaleOrder->save();

        $this->saleOrderRepository->syncCustomer($internalSaleOrder, $externalSaleOrder);
        $this->saleOrderRepository->syncInvoice($internalSaleOrder, $externalSaleOrder);
        $this->saleOrderRepository->syncShipment($internalSaleOrder, $externalSaleOrder);

        $profit = $this->calculateTotalProfit->execute($internalSaleOrder, $userId);
        $this->saleOrderRepository->updateProfit($internalSaleOrder, $profit);
    }

    private function updateSaleOrder(SaleOrder $saleOrder, SaleOrderInterface $externalSaleOrder, string $userId): void
    {
        $this->saleOrderRepository->updateStatus(
            $saleOrder,
            (string) $externalSaleOrder->getStatus()
        );
    }
}
