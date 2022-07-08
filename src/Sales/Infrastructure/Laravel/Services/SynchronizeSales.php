<?php

namespace Src\Sales\Infrastructure\Laravel\Services;

use Exception;
use Src\Sales\Domain\Events\SaleOrderWasNotSynchronized;
use Src\Sales\Domain\Models\Contracts\SaleOrder as SaleOrderInterface;
use Src\Sales\Domain\Models\SaleOrder;
use Src\Sales\Domain\Repositories\Contracts\ItemsRepository;
use Src\Sales\Domain\Repositories\Contracts\SynchronizationRepository;
use Src\Sales\Domain\Repositories\Contracts\Repository;

class SynchronizeSales
{
    private CalculateTotalProfit $calculateTotalProfit;
    private ItemsRepository $itemsRepository;
    private Repository $repository;
    private SynchronizationRepository $syncRepository;

    public function __construct(
        CalculateTotalProfit $calculateTotalProfit,
        ItemsRepository $itemRepository,
        Repository $repository,
        SynchronizationRepository $syncRepository
    ) {
        $this->calculateTotalProfit = $calculateTotalProfit;
        $this->itemsRepository = $itemRepository;
        $this->repository = $repository;
        $this->syncRepository = $syncRepository;
    }

    public function sync(array $data, string $userId)
    {
        foreach ($data as $saleOrder) {
            try {
                if (!$saleOrderModel = $this->getSaleOrder($saleOrder)) {

                    $this->insertSaleOrder($saleOrder, $userId);
                    continue;
                }

                $this->updateSaleOrder($saleOrderModel, $saleOrder, $userId);
            } catch (Exception $exception) {
                event(new SaleOrderWasNotSynchronized($exception->getMessage()));
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
