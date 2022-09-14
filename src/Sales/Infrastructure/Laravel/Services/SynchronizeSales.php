<?php

namespace Src\Sales\Infrastructure\Laravel\Services;

use Exception;
use Illuminate\Support\Facades\DB;
use Src\Sales\Infrastructure\Laravel\Events\SaleOrderWasNotSynchronized;
use Src\Sales\Domain\Models\Contracts\SaleOrder as SaleOrderInterface;
use Src\Sales\Infrastructure\Laravel\Models\SaleOrder;
use Src\Sales\Domain\Repositories\ErpRepository;
use Src\Sales\Domain\Repositories\SaleOrderRepository as SaleOrderRepositoryInterface;
use Src\Users\Domain\Repositories\Repository as UserRepository;

class SynchronizeSales
{
    public function __construct(
        private readonly CalculateTotalProfit$calculateTotalProfit,
        private readonly ErpRepository $erpRepository,
        private readonly SaleOrderRepositoryInterface $saleOrderRepository,
        private readonly UserRepository $userRepository
    ) {
    }

    public function sync(string $userId)
    {
        if (!$user = $this->userRepository->find($userId)) {
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
        DB::transaction(function () use ($externalSaleOrder, $userId) {
            $internalSaleOrder = $this->saleOrderRepository->insertSaleOrder($externalSaleOrder, $userId);
            $this->saleOrderRepository->insertSaleItems($internalSaleOrder, $externalSaleOrder);
            $this->saleOrderRepository->insertSaleInvoice($internalSaleOrder, $externalSaleOrder);
            $this->saleOrderRepository->insertShipment($internalSaleOrder, $externalSaleOrder);
            $profit = $this->calculateTotalProfit->execute($internalSaleOrder, $userId);
            $this->saleOrderRepository->updateProfit($internalSaleOrder, $profit);
        });
    }

    private function updateSaleOrder(SaleOrder $saleOrder, SaleOrderInterface $externalSaleOrder, string $userId): void
    {
        $this->saleOrderRepository->updateStatus(
            $saleOrder,
            (string) $externalSaleOrder->getStatus()
        );

        $profit = $this->calculateTotalProfit->execute($externalSaleOrder, $userId);
        $this->saleOrderRepository->updateProfit($saleOrder, $profit);
    }
}
