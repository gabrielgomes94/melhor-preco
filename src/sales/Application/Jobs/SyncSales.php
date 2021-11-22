<?php

namespace Src\Sales\Application\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Src\Sales\Application\Services\CalculateTotalProfit;
use Src\Sales\Domain\Events\SaleSynchronized;
use Src\Sales\Domain\Models\Contracts\SaleOrder as SaleOrderInterface;
use Src\Sales\Domain\Models\SaleOrder;
use Src\Sales\Domain\Repositories\Contracts\ErpRepository;
use Src\Sales\Infrastructure\Eloquent\Repository;

class SyncSales implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private CalculateTotalProfit $calculateTotalProfit;

    public function handle(ErpRepository $erpRepository, CalculateTotalProfit $calculateTotalProfit): void {
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
        $saleOrderId = $saleOrder->getIdentifiers()->id();

        return SaleOrder::where('sale_order_id', $saleOrderId)->first();
    }

    private function insertSaleOrder(
        SaleOrderInterface $externalSaleOrder,
        CalculateTotalProfit $calculateTotalProfit
    ): void {
        try {
            $saleOrderModel = Repository::insert($externalSaleOrder);

            Repository::syncInvoice($saleOrderModel, $externalSaleOrder);
            Repository::syncPayment($saleOrderModel, $externalSaleOrder);
            Repository::syncShipment($saleOrderModel, $externalSaleOrder);
            Repository::syncItems($saleOrderModel, $externalSaleOrder);

            $profit = $calculateTotalProfit->execute($saleOrderModel);
            Repository::updateProfit($saleOrderModel, $profit);

            event(new SaleSynchronized($saleOrderModel->id));

        } catch (Exception $exception) {
            return;
        }
    }

    private function updateSaleOrder(
        SaleOrder $model,
        SaleOrderInterface $externalSaleOrder,
        CalculateTotalProfit $calculateTotalProfit
    ): void {
        try {
            Repository::syncPayment($model, $externalSaleOrder);
            Repository::syncItems($model, $externalSaleOrder);
            $profit = $calculateTotalProfit->execute($model);
            Repository::updateProfit($model, $profit);

            $model->status = (string) $externalSaleOrder->getStatus();
            $model->save();
        } catch (Exception $exception) {
            return;
        }
    }
}
