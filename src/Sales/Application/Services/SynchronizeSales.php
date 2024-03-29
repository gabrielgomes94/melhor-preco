<?php

namespace Src\Sales\Application\Services;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Src\Sales\Domain\Models\Contracts\SaleOrder as SaleOrderInterface;
use Src\Sales\Application\Models\SaleOrder;
use Src\Sales\Domain\Repositories\ErpRepository;
use Src\Sales\Domain\Repositories\SaleOrderRepository as SaleOrderRepositoryInterface;
use Src\Users\Infrastructure\Laravel\Models\User;

class SynchronizeSales
{
    public function __construct(
        private readonly CalculateTotalProfit $calculateTotalProfit,
        private readonly ErpRepository $erpRepository,
        private readonly SaleOrderRepositoryInterface $saleOrderRepository,
    ) {
    }

    public function sync(User $user): void
    {
        $data = $this->erpRepository->list($user->getErpToken());

        /**
         * @var SaleOrder $saleOrder
         */
        foreach ($data as $saleOrder) {
            try {
                if (!$saleOrderModel = $this->getSaleOrder($saleOrder, $user->getId())) {
                    try {
                        $this->insertSaleOrder($saleOrder, $user->getId());
                    } catch (Exception $exception) {
                        Log::alert($exception->getMessage());
                    }


                    continue;
                }

                $this->updateSaleOrder($saleOrderModel, $saleOrder, $user->getId());
            } catch (Exception $exception) {
                // handle errors
            }
        }
    }

    private function getSaleOrder(SaleOrderInterface $saleOrder, string $userId): ?SaleOrder
    {
        $id = $saleOrder->getIdentifiers()->saleOrderId();

        return $this->saleOrderRepository->get($id, $userId);
    }

    private function insertSaleOrder(SaleOrderInterface $externalSaleOrder, string $userId): void
    {
        DB::transaction(function () use ($externalSaleOrder, $userId) {
            $internalSaleOrder = $this->saleOrderRepository->insertSaleOrder($externalSaleOrder, $userId);
            $this->saleOrderRepository->insertSaleItems($internalSaleOrder, $externalSaleOrder, $userId);
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
