<?php

namespace Src\Sales\Infrastructure\Eloquent;

use DateTime;
use Src\Sales\Domain\Factories\Address as AddressFactory;
use Src\Sales\Domain\Factories\Customer as CustomerFactory;
use Src\Sales\Domain\Factories\Invoice as InvoiceFactory;
use Src\Sales\Domain\Factories\Item;
use Src\Sales\Domain\Factories\PaymentInstallment as PaymentInstallmentFactory;
use Src\Sales\Domain\Factories\SaleOrder as SaleOrderFactory;
use Src\Sales\Domain\Factories\Shipment;
use Src\Sales\Domain\Models\Customer as CustomerModel;
use Src\Sales\Domain\Models\ValueObjects\Customer\Customer;
use Src\Sales\Domain\Models\Contracts\SaleOrder as SaleOrderInterface;
use Src\Sales\Domain\Models\SaleOrder;
use Src\Sales\Domain\Repositories\Contracts\Repository as RepositoryInterface;

class Repository implements RepositoryInterface
{
    public static function insert(SaleOrderInterface $externalSaleOrder): SaleOrder
    {
        $customer = self::getCustomer($externalSaleOrder->getCustomer());
        $internalSaleOrder = SaleOrderFactory::makeModel($externalSaleOrder);
        $internalSaleOrder->customer()->associate($customer);

        $internalSaleOrder->save();

        return $internalSaleOrder;
    }

    public static function syncInvoice(SaleOrder $internalSaleOrder, SaleOrderInterface $externalSaleOrder): void
    {
        if (!$externalSaleOrder->getInvoice()) {
            return;
        }

        $invoice = InvoiceFactory::makeModel($externalSaleOrder->getInvoice());
        $internalSaleOrder->invoice()->save($invoice);
    }

    public static function syncPayment(SaleOrder $internalSaleOrder, SaleOrderInterface $externalSaleOrder): void
    {
        if (!$externalSaleOrder->getPayment()) {
            return;
        }

        foreach ($externalSaleOrder->getPayment()->get() as $installment) {
            $payment = PaymentInstallmentFactory::makeModel($installment);
            $internalSaleOrder->payment()->save($payment);
        }
    }

    public static function syncShipment(SaleOrder $internalSaleOrder, SaleOrderInterface $externalSaleOrder): void
    {
        if (!$externalSaleOrder->getShipment()) {
            return;
        }

        $shipment = Shipment::makeModel($externalSaleOrder->getShipment());
        $internalSaleOrder->shipment()->save($shipment);

        $shipmentAddress = AddressFactory::makeModel($externalSaleOrder->getShipment()->getDeliveryAddress());
        $shipment->address()->save($shipmentAddress);
    }

    public static function syncItems(SaleOrder $internalSaleOrder, SaleOrderInterface $externalSaleOrder): void
    {
        foreach ($externalSaleOrder->getItems() as $item) {
            $itemModel = Item::makeModel($item);
            $internalSaleOrder->items()->save($itemModel);
        }
    }

    public static function listPaginate(
        int $page,
        int $perPage = RepositoryInterface::PER_PAGE,
        ?DateTime $beginDate = null,
        ?DateTime $endDate = null
    ) {
        return SaleOrder::valid()
            ->defaultOrder()
            ->paginate(page: $page, perPage: 40);
    }

    public static function getTotalValueSum(?DateTime $beginDate = null, ?DateTime $endDate = null)
    {
        return SaleOrder::valid()->sum('total_value');
    }

    public static function getTotalProfitSum(?DateTime $beginDate = null, ?DateTime $endDate = null)
    {
        return SaleOrder::valid()->sum('total_profit');
    }

    public static function updateProfit(SaleOrder $saleOrder, float $profit): void
    {
        $saleOrder->total_profit = $profit;
        $saleOrder->save();
    }

    private static function getCustomer(Customer $customer): CustomerModel
    {
        if (!$customerModel = CustomerModel::where('fiscal_id', $customer->getFiscalId())->first()) {
            $address = AddressFactory::makeModel($customer->getAddress());
            $customerModel = CustomerFactory::makeModel($customer);
            $customerModel->save();
            $customerModel->address()->save($address);
        }

        return $customerModel;
    }
}
