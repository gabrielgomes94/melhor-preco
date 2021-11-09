<?php

namespace Src\Sales\Application\UseCases;

use Src\Sales\Domain\Contracts\Repository\ErpRepository;
use Src\Sales\Domain\Contracts\UseCases\SyncSales as SyncSalesInterface;
use Src\Sales\Domain\Factories\Address as AddressFactory;
use Src\Sales\Domain\Factories\Customer as CustomerFactory;
use Src\Sales\Domain\Factories\Invoice as InvoiceFactory;
use Src\Sales\Domain\Factories\Item;
use Src\Sales\Domain\Factories\PaymentInstallment as PaymentInstallmentFactory;
use Src\Sales\Domain\Factories\SaleOrder as SaleOrderFactory;
use Src\Sales\Domain\Factories\Shipment;
use Src\Sales\Domain\Models\Customer as CustomerModel;
use Src\Sales\Domain\Models\Data\Customer\Customer;
use Src\Sales\Domain\Models\Data\SaleOrder as SaleOrderData;
use Src\Sales\Domain\Models\SaleOrder;

class SyncSales implements SyncSalesInterface
{
    private ErpRepository $erpRepository;

    public function __construct(ErpRepository $erpRepository)
    {
        $this->erpRepository = $erpRepository;
    }

    public function sync(): void
    {
        $data = $this->erpRepository->list();

        foreach ($data as $saleOrder) {
            if (!$saleOrderModel = SaleOrder::where('sale_order_id', $saleOrder->identifiers()->id())->first()) {
                try {
                    $this->insertSaleOrder($saleOrder);
                } catch (\Exception $exception) {
                }

                continue;
            }

            try {
                $this->updateSaleOrder($saleOrderModel, $saleOrder);
            } catch (\Exception $exception) {
            }
        }
    }

    private function insertSaleOrder(SaleOrderData $saleOrder)
    {
        $customer = $this->getCustomer($saleOrder->customer());

        $saleOrderModel = SaleOrderFactory::makeModel($saleOrder);
        $customer->save();
        $saleOrderModel->customer()->associate($customer);
        $saleOrderModel->save();

        if ($saleOrder->payment()) {
            foreach ($saleOrder->payment()->get() as $installment) {
                $payment = PaymentInstallmentFactory::makeModel($installment);
                $saleOrderModel->payment()->save($payment);
            }
        }

        if ($saleOrder->invoice()) {
            $invoice = InvoiceFactory::makeModel($saleOrder->invoice());
            $saleOrderModel->invoice()->save($invoice);
        }

        if ($saleOrder->shipment()) {
            $shipment = Shipment::makeModel($saleOrder->shipment());
            $saleOrderModel->shipment()->save($shipment);

            $shipmentAddress = AddressFactory::makeModel($saleOrder->shipment()->getDeliveryAddress());
            $shipment->address()->save($shipmentAddress);
        }

        foreach ($saleOrder->items() as $item) {
            $itemModel = Item::makeModel($item);

            $saleOrderModel->items()->save($itemModel);
        }
    }

    private function updateSaleOrder(SaleOrder $model, SaleOrderData $saleOrder)
    {
        $model->status = (string) $saleOrder->status();
        $model->save();
    }

    private function getCustomer(Customer $customer): CustomerModel
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
