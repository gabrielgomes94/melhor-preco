<?php

namespace Src\Sales\Infrastructure\Eloquent;

use Carbon\Carbon;
use Src\Products\Infrastructure\Config\StoreRepository;
use Src\Sales\Domain\Events\CustomerSynchronized;
use Src\Sales\Domain\Events\InvoiceSynchronized;
use Src\Sales\Domain\Events\ItemSynchronized;
use Src\Sales\Domain\Events\PaymentSynchronized;
use Src\Sales\Domain\Events\SaleSynchronized;
use Src\Sales\Domain\Events\ShipmentSynchronized;
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
        $customer = self::getOrCreateCustomer($externalSaleOrder->getCustomer());
        $internalSaleOrder = SaleOrderFactory::makeModel($externalSaleOrder);
        $internalSaleOrder->customer()->associate($customer);
        $result = $internalSaleOrder->save();

        if ($result) {
            event(new CustomerSynchronized($internalSaleOrder->customer->getId()));
        }

        return $internalSaleOrder;
    }

    public static function syncInvoice(SaleOrder $internalSaleOrder, SaleOrderInterface $externalSaleOrder): void
    {
        if (!$invoice = $externalSaleOrder->getInvoice()) {
            return;
        }

        $invoice = InvoiceFactory::makeModel($invoice);
        $result = $internalSaleOrder->invoice()->save($invoice);

        if ($result) {
            event(new InvoiceSynchronized($invoice->id));
        }
    }

    public static function syncPayment(SaleOrder $internalSaleOrder, SaleOrderInterface $externalSaleOrder): void
    {
        if (!$payment = $externalSaleOrder->getPayment()) {
            return;
        }

        foreach ($payment->get() as $installment) {
            $installmentModel = PaymentInstallmentFactory::makeModel($installment);

            $result = $internalSaleOrder->payment()->save(
                $installmentModel
            );

            if ($result)  {
                event(new PaymentSynchronized($installmentModel->id));
            }
        }
    }

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

    public static function syncItems(SaleOrder $internalSaleOrder, SaleOrderInterface $externalSaleOrder): void
    {
        foreach ($externalSaleOrder->getItems() as $item) {
            $itemModel = Item::makeModel($item);
            $result = $internalSaleOrder->items()->save($itemModel);

            if ($result) {
                event(new ItemSynchronized($itemModel->id));
            }
        }
    }

    public static function listPaginate(
        int $page,
        int $perPage = RepositoryInterface::PER_PAGE,
        ?Carbon $beginDate = null,
        ?Carbon $endDate = null
    ) {
        return SaleOrder::valid()
            ->inDateInterval($beginDate, $endDate)
            ->defaultOrder()
            ->paginate(page: $page, perPage: 40);
    }

    public static function getTotalValueSum(?Carbon $beginDate = null, ?Carbon $endDate = null)
    {
        return SaleOrder::valid()
            ->inDateInterval($beginDate, $endDate)
            ->sum('total_value');
    }

    public static function getTotalProfitSum(?Carbon $beginDate = null, ?Carbon $endDate = null)
    {
        return SaleOrder::valid()
            ->inDateInterval($beginDate, $endDate)
            ->sum('total_profit');
    }

    public static function getTotalSalesCount(Carbon $beginDate, Carbon $endDate)
    {
        return SaleOrder::valid()
            ->inDateInterval($beginDate, $endDate)
            ->count();
    }

    public static function getTotalProductsCount(Carbon $beginDate, Carbon $endDate)
    {
        return SaleOrder::withCount('items')
            ->inDateInterval($beginDate, $endDate)
            ->count();
    }

    public static function getTotalStoresCount(Carbon $beginDate, Carbon $endDate)
    {
        $stores = StoreRepository::all();

        foreach ($stores as $store) {
            $slug = $store->getSlug();

            $storeList[$slug] = [
                'count' => SaleOrder::valid()
                    ->inDateInterval($beginDate, $endDate)
                    ->where('store_id', $store->getErpCode())
                    ->count(),
                'name' => $store->getName(),
            ];
        }

        return $storeList ?? [];
    }

    public static function updateProfit(SaleOrder $saleOrder, float $profit): void
    {
        $saleOrder->total_profit = $profit;
        $result = $saleOrder->save();

        if ($result) {
            event(new SaleSynchronized($saleOrder->id));
        }
    }

    private static function getOrCreateCustomer(Customer $customer): CustomerModel
    {
        $fiscalId = $customer->getFiscalId();
        $customerModel = CustomerModel::where('fiscal_id', $fiscalId)->first();

        if ($customerModel) {
            return $customerModel;
        }

        $customerModel = self::createCustomer($customer);
        event(new CustomerSynchronized($customerModel->id));

        return $customerModel;
    }

    private static function createCustomer(Customer $customer): CustomerModel
    {
        $address = AddressFactory::makeModel($customer->getAddress());
        $customerModel = CustomerFactory::makeModel($customer);
        $customerModel->save();

        $customerModel->address()->save($address);

        return $customerModel;
    }
}
