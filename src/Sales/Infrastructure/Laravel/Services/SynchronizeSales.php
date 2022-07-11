<?php

namespace Src\Sales\Infrastructure\Laravel\Services;

use Exception;
use Src\Sales\Domain\Events\SaleOrderWasNotSynchronized;
use Src\Sales\Domain\Models\Contracts\SaleOrder as SaleOrderInterface;
use Src\Sales\Domain\Models\SaleOrder;
use Src\Sales\Domain\Repositories\ErpRepository;
use Src\Sales\Domain\Repositories\Contracts\ItemsRepository;
use Src\Sales\Domain\Repositories\Contracts\SynchronizationRepository;
use Src\Sales\Domain\Repositories\Contracts\Repository;
use Src\Sales\Infrastructure\Laravel\Services\CalculateTotalProfit;

class SynchronizeSales
{
    private CalculateTotalProfit $calculateTotalProfit;
    private ItemsRepository $itemsRepository;
    private Repository $repository;
    private SynchronizationRepository $syncRepository;
    private ErpRepository $erpRepository;

    public function __construct(
        CalculateTotalProfit $calculateTotalProfit,
        ItemsRepository $itemRepository,
        Repository $repository,
        SynchronizationRepository $syncRepository,
        ErpRepository $erpRepository
    ) {
        $this->calculateTotalProfit = $calculateTotalProfit;
        $this->itemsRepository = $itemRepository;
        $this->repository = $repository;
        $this->syncRepository = $syncRepository;
        $this->erpRepository = $erpRepository;
    }

    public function sync(string $userId)
    {
        $data = $this->erpRepository->list();

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
        $saleOrderModel = $this->syncRepository->insert($externalSaleOrder, $userId);

        $this->itemsRepository->insert($saleOrderModel, $externalSaleOrder->getItems());
        $this->syncRepository->syncInvoice($saleOrderModel, $externalSaleOrder);
        $this->syncRepository->syncShipment($saleOrderModel, $externalSaleOrder);


        $this->repository->update(
            saleOrder: $saleOrderModel,
            profit: $this->calculateTotalProfit->execute($saleOrderModel, $userId)
        );
    }

    private function updateSaleOrder(SaleOrder $saleOrder, SaleOrderInterface $externalSaleOrder, string $userId): void
    {
        $this->repository->update(
            saleOrder: $saleOrder,
            profit: $this->calculateTotalProfit->execute($saleOrder, $userId),
            status: (string) $externalSaleOrder->getStatus()
        );
    }
}
