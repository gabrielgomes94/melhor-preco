<?php

namespace Barrigudinha\SaleOrder\Factories;

use Barrigudinha\SaleOrder\Entities\Customer;
use Barrigudinha\SaleOrder\Entities\SaleOrder as SaleOrderEntity;
use Barrigudinha\SaleOrder\ValueObjects\Address\Address;
use Barrigudinha\SaleOrder\ValueObjects\Identifiers;
use Barrigudinha\SaleOrder\ValueObjects\Invoice\NullInvoice;
use Barrigudinha\SaleOrder\ValueObjects\Payment\Installment;
use Barrigudinha\SaleOrder\ValueObjects\Invoice\Invoice;
use Barrigudinha\SaleOrder\ValueObjects\Item;
use Barrigudinha\SaleOrder\ValueObjects\Items;
use Barrigudinha\SaleOrder\ValueObjects\Payment\NullPayment;
use Barrigudinha\SaleOrder\ValueObjects\Payment\Payment;
use Barrigudinha\SaleOrder\ValueObjects\SaleDates;
use Barrigudinha\SaleOrder\ValueObjects\SaleValue;
use Barrigudinha\SaleOrder\ValueObjects\Shipment\NullShipment;
use Barrigudinha\SaleOrder\ValueObjects\Shipment\Shipment;
use Barrigudinha\SaleOrder\ValueObjects\Status;

class SaleOrder
{
    public static function make(array $data): SaleOrderEntity
    {
        $identifiers = self::makeIdentifiers($data['identifiers']);
        $saleValue = self::makeSaleValue($data['saleValue']);
        $saleDates = self::makeSaleDates($data['saleDates']);
        $customer = self::makeCustomer($data['customer']);
        $invoice = self::makeInvoice($data['invoice']);
        $items = self::makeItems($data['items']);
        $payment = self::makePayment($data['payment'] ?? []);
        $shipment = self::makeShipment($data['shipment']);

        $status = new Status($data['status']);
        if (!$status->isValid()) {
            throw new \Exception('Status inválido!');
        }

        return new SaleOrderEntity(
            $identifiers,
            $saleValue,
            $saleDates,
            $status,
            $customer,
            $invoice,
            $items,
            $payment,
            $shipment
        );
    }

    private static function makeIdentifiers(array $data): Identifiers
    {
        return new Identifiers(
            id: $data['id'],
            purchaseOrderId: $data['purchaseOrderId'],
            integration: $data['integration'],
            storeId: $data['storeId'],
            storeSaleOrderId: $data['storeSaleOrderId'],
        );
    }

    private static function makeSaleValue(array $data): SaleValue
    {
        return new SaleValue(
            $data['discount'],
            $data['freight'],
            $data['totalProducts'],
            $data['totalValue'],
        );
    }

    private static function makeSaleDates(array $data): SaleDates
    {
        return new SaleDates(
            $data['selledAt'],
            $data['dispatchedAt'],
            $data['expectedArrivalAt']
        );
    }

    private static function makeCustomer(array $data): Customer
    {
        $address = self::makeAddress($data['address']);

        return new Customer(
            name: $data['name'],
            fiscalId: $data['fiscalId'],
            stateRegistration: $data['stateRegistration'] ?? '',
            documentNumber: $data['documentNumber'] ?? '',
            phones: $data['phones'] ?? [],
            address: $address,
            email: $data['email'] ?? null
        );
    }

    private static function makeAddress(array $data): Address
    {
        return new Address(
            street: $data['street'],
            number: $data['number'],
            district: $data['district'],
            city: $data['city'],
            state: $data['state'],
            zipcode: $data['zipcode'],
            complement: $data['complement'] ?? null
        );
    }

    private static function makeInvoice(array $data): Invoice
    {
        if (empty($data)) {
            return new NullInvoice();
        }

        return new Invoice(
            series: $data['series'],
            number: $data['number'],
            issuedAt: $data['issuedAt'],
            status: $data['status'],
            value: $data['value'],
            accessKey: $data['accessKey']
        );
    }

    private static function makeItems(array $data): Items
    {
        $items = array_map(function (array $item) {
            return new Item(
                sku: $item['sku'],
                name: $item['name'],
                quantity: $item['quantity'],
                unitValue: $item['unitValue'],
                discount: $item['discount'],
            );
        }, $data);

        return new Items($items);
    }

    private static function makePayment(array $data): Payment
    {
        if (empty($data)) {
            return new NullPayment();
        }

        $installments = array_map(function (array $installments) {
            return new Installment(
                id: $installments['id'],
                value: $installments['value'],
                expiresAt: $installments['expiresAt'],
                observation: $installments['observation'],
                destination: $installments['destination']
            );
        }, $data);

        return new Payment($installments);
    }

    private static function makeShipment(array $data): Shipment
    {
        if (empty($data)) {
            return new NullShipment();
        }

        $address = self::makeAddress($data['address']);

        return new Shipment(
            deliveryAddress: $address,
            name: $data['name']
        );
    }
}