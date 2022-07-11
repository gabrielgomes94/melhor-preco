<?php

namespace Src\Sales\Infrastructure\Laravel\Models\Concerns;

use Src\Sales\Domain\Factories\Customer as CustomerFactory;
use Src\Sales\Domain\Factories\Invoice;
use Src\Sales\Domain\Factories\Item;
use Src\Sales\Domain\Factories\Shipment as ShipmentFactory;
use Src\Sales\Domain\Models\ValueObjects\Customer\Customer as CustomerData;
use Src\Sales\Domain\Models\ValueObjects\Invoice\Invoice as InvoiceObject;
use Src\Sales\Domain\Models\ValueObjects\Items\Items;
use Src\Sales\Domain\Models\ValueObjects\Shipment\Shipment as ShipmentData;

trait SaleOrderGetters
{
    public function getCustomer(): CustomerData
    {
        return CustomerFactory::make($this->customer);
    }

    public function getItems(): Items
    {
        foreach ($this->items as $item) {
            $items[] = Item::make($item);
        }

        return new Items($items ?? []);
    }

    public function getInvoice(): InvoiceObject
    {
        return Invoice::make($this->invoice);
    }

    public function getShipment(): ShipmentData
    {
        return ShipmentFactory::make($this->shipment);
    }
}
