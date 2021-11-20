<?php

namespace Src\Sales\Application\UseCases;

use Exception;
use Src\Prices\Calculator\Domain\Services\CalculatePrice;
use Src\Sales\Application\Services\CalculateTotalProfit;
use Src\Sales\Domain\Repositories\Contracts\ErpRepository;
use Src\Sales\Domain\UseCases\Contracts\SyncSales as SyncSalesInterface;
use Src\Sales\Domain\Models\SaleOrder;
use Src\Sales\Infrastructure\Eloquent\Repository;
use Src\Sales\Domain\Models\Contracts\SaleOrder as SaleOrderInterface;

class SyncSales implements SyncSalesInterface
{
    private ErpRepository $erpRepository;
    private CalculatePrice $calculatePrice;
    private CalculateTotalProfit $calculateTotalProfit;

    public function __construct(
        ErpRepository $erpRepository,
        CalculatePrice $calculatePrice,
        CalculateTotalProfit $calculateTotalProfit
    ) {
        $this->erpRepository = $erpRepository;
        $this->calculatePrice = $calculatePrice;
        $this->calculateTotalProfit = $calculateTotalProfit;
    }

    public function sync(): void
    {
        $data = $this->erpRepository->list();

        foreach ($data as $saleOrder) {
            if (!$saleOrderModel = SaleOrder::where('sale_order_id', $saleOrder->getIdentifiers()->id())->first()) {
                $this->insertSaleOrder($saleOrder);

                continue;
            }

            $this->updateSaleOrder($saleOrderModel, $saleOrder);
        }
    }

    private function insertSaleOrder(SaleOrderInterface $externalSaleOrder)
    {
        try {
            $saleOrderModel = Repository::insert($externalSaleOrder);

            Repository::syncInvoice($saleOrderModel, $externalSaleOrder);
            Repository::syncPayment($saleOrderModel, $externalSaleOrder);
            Repository::syncShipment($saleOrderModel, $externalSaleOrder);
            Repository::syncItems($saleOrderModel, $externalSaleOrder);

            $profit = $this->calculateTotalProfit->execute($saleOrderModel);
            Repository::updateProfit($saleOrderModel, $profit);

        } catch (Exception $exception) {
            return;
        }
    }

    private function updateSaleOrder(SaleOrder $model, SaleOrderInterface $externalSaleOrder)
    {
        try {
            Repository::syncPayment($model, $externalSaleOrder);
            Repository::syncItems($model, $externalSaleOrder);
            $profit = $this->calculateTotalProfit->execute($model);
            Repository::updateProfit($model, $profit);

            $model->status = (string) $externalSaleOrder->getStatus();
            $model->save();
        } catch (Exception $exception) {
            return;
        }
    }
}
