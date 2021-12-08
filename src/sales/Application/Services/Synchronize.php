<?php

namespace Src\Sales\Application\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use Src\Sales\Domain\Models\Contracts\SaleOrder as SaleOrderInterface;
use Src\Sales\Domain\Models\SaleOrder;
use Src\Sales\Domain\Repositories\Contracts\ItemRepository;
use Src\Sales\Domain\Repositories\Contracts\SynchronizationRepository;
use Src\Sales\Infrastructure\Eloquent\Repositories\Repository;

// @todo: Fazer inversão de controle dos repositórios
class Synchronize
{
    private CalculateTotalProfit $calculateTotalProfit;
    private ItemRepository $itemsRepository;
    private SynchronizationRepository $syncRepository;

    public function __construct(
        CalculateTotalProfit $calculateTotalProfit,
        ItemRepository $itemRepository,
        SynchronizationRepository $syncRepository
    ) {
        $this->calculateTotalProfit = $calculateTotalProfit;
        $this->itemsRepository = $itemRepository;
        $this->syncRepository = $syncRepository;
    }

    public function sync(array $data)
    {
        foreach ($data as $saleOrder) {
            try {
                if (!$saleOrderModel = $this->getSaleOrder($saleOrder)) {
                    $this->insertSaleOrder($saleOrder);
                    continue;
                }

                $this->updateSaleOrder($saleOrderModel, $saleOrder);
            } catch (Exception $exception) {
                Log::error($exception->getMessage());
            }
        }
    }

    private function getSaleOrder(SaleOrderInterface $saleOrder): ?SaleOrder
    {
        return SaleOrder::where(
            'sale_order_id',
            $saleOrder->getIdentifiers()->id()
        )->first();
    }

    private function insertSaleOrder(SaleOrderInterface $externalSaleOrder): void
    {
        $saleOrderModel = $this->syncRepository->insert($externalSaleOrder);
        $this->itemsRepository->insert($saleOrderModel, $externalSaleOrder->getItems());

        Repository::update(
            saleOrder: $saleOrderModel,
            profit: $this->calculateTotalProfit->execute($saleOrderModel)
        );
    }

    private function updateSaleOrder(SaleOrder $saleOrder, SaleOrderInterface $externalSaleOrder): void
    {
        Repository::update(
            saleOrder: $saleOrder,
            profit: $this->calculateTotalProfit->execute($saleOrder),
            status: (string) $externalSaleOrder->getStatus()
        );
    }
}
