<?php

namespace Src\Sales\Infrastructure\Laravel\Repositories;

use Carbon\Carbon;
use Src\Sales\Domain\DataTransfer\SalesFilter;
use Src\Sales\Domain\Events\CustomerSynchronized;
use Src\Sales\Domain\Factories\Address as AddressFactory;
use Src\Sales\Domain\Factories\Customer as CustomerFactory;
use Src\Sales\Domain\Factories\Invoice as InvoiceFactory;
use Src\Sales\Domain\Factories\Item;
use Src\Sales\Domain\Factories\SaleOrder as SaleOrderFactory;
use Src\Sales\Domain\Factories\Shipment;
use Src\Sales\Domain\Models\Contracts\SaleOrder as SaleOrderInterface;
use Src\Sales\Domain\Models\Customer as CustomerModel;
use Src\Sales\Domain\Models\SaleOrder;
use Src\Sales\Domain\Repositories\SaleOrderRepository as SaleOrderRepositoryInterface;

class SaleOrderRepository implements SaleOrderRepositoryInterface
{
    public function getLastSaleDateTime(string $userId): ?Carbon
    {
        $lastUpdatedProduct = SaleOrder::where('user_id', $userId)
            ->orderByDesc('selled_at')
            ->first();

        return $lastUpdatedProduct?->getLastUpdate();
    }

    public function countSales(SalesFilter $options): int
    {
        return SaleOrder::where('user_id', $options->getUserId())
            ->valid()
            ->inDateInterval(
                $options->getBeginDate(),
                $options->getEndDate()
            )
            ->count();
    }

    public function listPaginate(SalesFilter $options)
    {
        return SaleOrder::valid()
            ->inDateInterval(
                $options->getBeginDate(),
                $options->getEndDate()
            )
            ->defaultOrder()
            ->paginate(
                page: $options->getPage(),
                perPage: $options->getPerPage()
            );
    }

    public function syncCustomer(SaleOrder $internalSaleOrder, SaleOrderInterface $externalSaleOrder): void
    {
        $customer = $externalSaleOrder->getCustomer();
        $fiscalId = $customer->getFiscalId();

        if (!$customerModel = CustomerModel::where('fiscal_id', $fiscalId)->first()) {
            $address = AddressFactory::makeModel($customer->getAddress());

            $customerModel = CustomerFactory::makeModel($customer);
            $customerModel->save();
            $customerModel->address()->save($address);
        }

        $internalSaleOrder->customer()->associate($customerModel);
    }


    public function syncInvoice(SaleOrder $internalSaleOrder, SaleOrderInterface $externalSaleOrder): void
    {
        if (!$invoice = $externalSaleOrder->getInvoice()) {
            return;
        }

        $invoice = InvoiceFactory::makeModel($invoice);
        $internalSaleOrder->invoice()->save($invoice);
    }

    public function syncItems(SaleOrder $internalSaleOrder, SaleOrderInterface $externalSaleOrder): void
    {
        foreach ($externalSaleOrder->getItems() as $item) {
            $itemModel = Item::makeModel($item);

            $internalSaleOrder->items()->save($itemModel);
        }
    }

    public function syncShipment(SaleOrder $internalSaleOrder, SaleOrderInterface $externalSaleOrder): void
    {
        if (!$shipment = $externalSaleOrder->getShipment()) {
            return;
        }

        $shipmentModel = Shipment::makeModel($shipment);
        $internalSaleOrder->shipment()->save($shipmentModel);

        $shipmentAddress = AddressFactory::makeModel($shipment->getDeliveryAddress());
        $shipmentModel->address()->save($shipmentAddress);
    }

    public function syncSaleOrder(SaleOrderInterface $externalSaleOrder, string $userId): SaleOrder
    {
        $internalSaleOrder = SaleOrderFactory::makeModel($externalSaleOrder);
        $internalSaleOrder->user_id = $userId;


        $internalSaleOrder->save();

        return $internalSaleOrder;
    }

    public function updateProfit(SaleOrder $saleOrder, string $profit): bool
    {
        $saleOrder->total_profit = $profit;

        return $saleOrder->save();
    }

    public function updateStatus(SaleOrder $saleOrder, string $status): bool
    {
        $saleOrder->status = $status;

        return $saleOrder->save();
    }
}
