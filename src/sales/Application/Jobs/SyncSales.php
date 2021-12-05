<?php

namespace Src\Sales\Application\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Src\Sales\Application\Services\CalculateTotalProfit;
use Src\Sales\Domain\Models\Contracts\SaleOrder as SaleOrderInterface;
use Src\Sales\Domain\Models\SaleOrder;
use Src\Sales\Domain\Repositories\Contracts\ErpRepository;
use Src\Sales\Infrastructure\Eloquent\Repository;
use Src\Sales\Infrastructure\Eloquent\SyncRepository;

class SyncSales implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private CalculateTotalProfit $calculateTotalProfit;

    public function handle(ErpRepository $erpRepository, CalculateTotalProfit $calculateTotalProfit): void
    {
        $data = $erpRepository->list();

        foreach ($data as $saleOrder) {
            if (!$saleOrderModel = $this->getSaleOrder($saleOrder)) {
                $this->insertSaleOrder($saleOrder, $calculateTotalProfit);

                continue;
            }

            $this->updateSaleOrder($saleOrderModel, $saleOrder, $calculateTotalProfit);
        }
    }

    private function getSaleOrder(SaleOrderInterface $saleOrder): ?SaleOrder
    {
        return SaleOrder::where(
            'sale_order_id',
            $saleOrder->getIdentifiers()->id()
        )->first();
    }

    private function insertSaleOrder(
        SaleOrderInterface $externalSaleOrder,
        CalculateTotalProfit $calculateTotalProfit
    ): void {
        try {
            $saleOrderModel = SyncRepository::insert($externalSaleOrder);
            SyncRepository::syncInvoice($saleOrderModel, $externalSaleOrder);
            SyncRepository::syncPayment($saleOrderModel, $externalSaleOrder);
            SyncRepository::syncShipment($saleOrderModel, $externalSaleOrder);
            SyncRepository::syncItems($saleOrderModel, $externalSaleOrder);

            Repository::update(
                saleOrder: $saleOrderModel,
                profit: $calculateTotalProfit->execute($saleOrderModel)
            );
        } catch (Exception $exception) {
            return;
        }
    }

    private function updateSaleOrder(
        SaleOrder $saleOrder,
        SaleOrderInterface $externalSaleOrder,
        CalculateTotalProfit $calculateTotalProfit
    ): void {
        try {
            SyncRepository::syncPayment($saleOrder, $externalSaleOrder);
            SyncRepository::syncItems($saleOrder, $externalSaleOrder);

            Repository::update(
                saleOrder: $saleOrder,
                profit: $calculateTotalProfit->execute($saleOrder),
                status: (string) $externalSaleOrder->getStatus()
            );
        } catch (Exception $exception) {
            return;
        }
    }
}
