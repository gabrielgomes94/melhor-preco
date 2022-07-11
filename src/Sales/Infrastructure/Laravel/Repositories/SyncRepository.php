<?php

namespace Src\Sales\Infrastructure\Laravel\Repositories;

use Src\Sales\Domain\Events\CustomerSynchronized;
use Src\Sales\Domain\Events\InvoiceSynchronized;
use Src\Sales\Domain\Events\ItemSynchronized;
use Src\Sales\Domain\Events\ShipmentSynchronized;
use Src\Sales\Domain\Factories\Address as AddressFactory;
use Src\Sales\Domain\Factories\Invoice as InvoiceFactory;
use Src\Sales\Domain\Factories\Item;
use Src\Sales\Domain\Factories\SaleOrder as SaleOrderFactory;
use Src\Sales\Domain\Factories\Shipment;
use Src\Sales\Domain\Models\Contracts\SaleOrder as SaleOrderInterface;
use Src\Sales\Domain\Models\Customer as CustomerModel;
use Src\Sales\Domain\Models\SaleOrder;
use Src\Sales\Domain\Repositories\Contracts\SynchronizationRepository;
use function event;

class SyncRepository implements SynchronizationRepository
{
    public function insert(SaleOrderInterface $externalSaleOrder, string $userId): SaleOrder
    {
        $internalSaleOrder = SaleOrderFactory::makeModel($externalSaleOrder);
        $internalSaleOrder->customer()->associate(
            $this->getCustomerModel($externalSaleOrder)
        );

        $internalSaleOrder->user_id = $userId;
        if ($internalSaleOrder->save()) {
            event(new CustomerSynchronized($internalSaleOrder->customer->getId()));
        }

        return $internalSaleOrder;
    }

    /**
     * @deprecated
     */
    public static function syncShipment(SaleOrder $internalSaleOrder, SaleOrderInterface $externalSaleOrder): void
    {
        if (!$shipment = $externalSaleOrder->getShipment()) {
            return;
        }

        $shipmentModel = Shipment::makeModel($shipment);

        $internalSaleOrder->shipment()->save($shipmentModel);
        $shipmentAddress = AddressFactory::makeModel($shipment->getDeliveryAddress());
        $result = $shipmentModel->address()->save($shipmentAddress);

        if ($result) {
            event(new ShipmentSynchronized($shipmentModel->id));
        }
    }

    /**
     * @deprecated
     */
    public static function syncInvoice(SaleOrder $internalSaleOrder, SaleOrderInterface $externalSaleOrder): void
    {
        if (!$invoice = $externalSaleOrder->getInvoice()) {
            return;
        }

        $invoice = InvoiceFactory::makeModel($invoice);

        if ($internalSaleOrder->invoice()->save($invoice)) {
            event(new InvoiceSynchronized($invoice->id));
        }
    }

    /**
     * @deprecated
     */
    public static function syncItems(SaleOrder $internalSaleOrder, SaleOrderInterface $externalSaleOrder): void
    {
        foreach ($externalSaleOrder->getItems() as $item) {
            $itemModel = Item::makeModel($item);

            if ($internalSaleOrder->items()->save($itemModel)) {
                event(new ItemSynchronized($itemModel->id));
            }
        }
    }

    private function getCustomerModel(SaleOrderInterface $externalSaleOrder): CustomerModel
    {
        $customer = $externalSaleOrder->getCustomer();
        $fiscalId = $customer->getFiscalId();

        if (!$customerModel = CustomerModel::where('fiscal_id', $fiscalId)->first()) {
            $customerModel = CustomerRepository::create($customer);
        }

        return $customerModel;
    }
}
