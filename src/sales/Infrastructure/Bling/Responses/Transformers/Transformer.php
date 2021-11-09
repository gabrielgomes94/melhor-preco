<?php

namespace Src\Sales\Infrastructure\Bling\Responses\Transformers;

use Carbon\Carbon;
use Src\Sales\Domain\Models\Data\Address\Address;
use Src\Sales\Domain\Models\Data\Customer\Customer;
use Src\Sales\Domain\Models\Data\Identifiers\Identifiers;
use Src\Sales\Domain\Models\Data\Invoice\Invoice;
use Src\Sales\Domain\Models\Data\Items\Item;
use Src\Sales\Domain\Models\Data\Items\Items;
use Src\Sales\Domain\Models\Data\Payment\Installment;
use Src\Sales\Domain\Models\Data\Payment\Payment;
use Src\Sales\Domain\Models\Data\Sale\SaleDates;
use Src\Sales\Domain\Models\Data\Sale\SaleValue;
use Src\Sales\Domain\Models\Data\SaleOrder;
use Src\Sales\Domain\Models\Data\Shipment\Shipment;
use Src\Sales\Domain\Models\Data\Status\Status;

class Transformer
{
    public static function transform(array $data)
    {
        $identifiers = new Identifiers(
            id: $data['numero'],
            purchaseOrderId: $data['numeroOrdemCompra'],
            integration: $data['tipoIntegracao'] ?? null,
            storeId: $data['loja'] ?? null,
            storeSaleOrderId: $data['numeroPedidoLoja'] ?? null
        );

        $saleValue = new SaleValue(
            discount: (float) $data['desconto'],
            freight: (float) $data['valorfrete'],
            totalProducts: (float) $data['totalprodutos'],
            totalValue: (float) $data['totalvenda']
        );

        $saleDates = new SaleDates(
            selledAt: Carbon::createFromFormat('Y-m-d', $data['data']),
            dispatchedAt: isset($data['dataSaida'])
                ? Carbon::createFromFormat('Y-m-d', $data['dataSaida'])
                : null,
            expectedArrivalAt: isset($data['dataPrevista'])
                ? Carbon::createFromFormat('Y-m-d', $data['dataPrevista'])
                : null
        );

        $status = new Status($data['situacao']);

        $customer = self::makeCustomer($data);
        $invoice = self::makeInvoice($data);
        $items = self::makeItems($data);
        $shipment = self::makeShipment($data);
        $payment = self::makePayment($data);

        return new SaleOrder(
            identifiers: $identifiers,
            saleValue: $saleValue,
            saleDates: $saleDates,
            status: $status,
            items: $items,
            customer: $customer,
            invoice: $invoice,
            payment: $payment,
            shipment: $shipment
        );
    }

    private static function makeCustomer(array $data)
    {
        $address = new Address(
            street: $data['cliente']['endereco'] ?? '',
            number: $data['cliente']['numero'] ?? '',
            district: $data['cliente']['bairro'] ?? '',
            city: $data['cliente']['cidade'] ?? '',
            state: $data['cliente']['uf'] ?? '',
            zipcode: $data['cliente']['cep'] ?? '',
            complement: $data['cliente']['complemento'] ?? ''
        );


        $mainPhone = self::removeNonDigits($data['cliente']['fone'])
            ? ['+55' . self::removeNonDigits($data['cliente']['fone'])]
            : [];

        $secondaryPhone = self::removeNonDigits($data['cliente']['celular'])
            ? ['+55' . self::removeNonDigits($data['cliente']['celular'])]
            : [];

        $phones = array_merge(
            $mainPhone,
            $secondaryPhone
        );

        return new Customer(
            name: $data['cliente']['nome'],
            fiscalId: self::removeNonDigits(
                $data['cliente']['cnpj']
                ?? $data['cliente']['cpf']
                ?? ''
            ),
            phones: $phones,
            address: $address,
            documentNumber: $data['cliente']['rg']
        );
    }

    private static function makeInvoice(array $data)
    {
        if (!isset($data['nota'])) {
            return null;
        }

        return new Invoice(
            series: $data['nota']['serie'],
            number: $data['nota']['numero'],
            issuedAt: Carbon::createFromFormat('Y-m-d H:i:s', $data['nota']['dataEmissao']),
            status: $data['nota']['situacao'],
            value: $data['nota']['valorNota'],
            accessKey: $data['nota']['chaveAcesso'] ?? ''
        );
    }

    private static function makeItems(array $data)
    {
        $items = array_map(function (array $item) {
            return new Item(
                sku: $item['item']['codigo'] ?? '',
                name: $item['item']['descricao'],
                quantity: $item['item']['quantidade'],
                unitValue: $item['item']['valorunidade'],
                discount: $item['item']['descontoItem']
            );
        }, $data['itens']);

        return new Items($items);
    }

    private static function makeShipment(array $data)
    {
        if (!isset($data['transporte'])) {
            return null;
        }

        $address = new Address(
            street: $data['transporte']['enderecoEntrega']['endereco'],
            number: $data['transporte']['enderecoEntrega']['numero'],
            district: $data['transporte']['enderecoEntrega']['bairro'],
            city: $data['transporte']['enderecoEntrega']['cidade'],
            state: $data['transporte']['enderecoEntrega']['uf'],
            zipcode: $data['transporte']['enderecoEntrega']['cep'],
            complement: $data['transporte']['enderecoEntrega']['complemento']
        );

        return new Shipment(
            deliveryAddress: $address,
            name: $data['transporte']['enderecoEntrega']['nome'] ?? '',
        );
    }

    private static function makePayment(array $data)
    {
        if (!isset($data['parcelas'])) {
            return null;
        }

        $installments = array_map(function (array $paymentInstallment) {

            return new Installment(
                id: $paymentInstallment['parcela']['idLancamento'],
                value: $paymentInstallment['parcela']['valor'],
                expiresAt: Carbon::createFromFormat(
                    'Y-m-d H:i:s',
                    $paymentInstallment['parcela']['dataVencimento']
                ),
                observation: $paymentInstallment['parcela']['obs'],
                destination: $paymentInstallment['parcela']['destino']
            );
        }, $data['parcelas']);

        return new Payment($installments);
    }

    private static function removeNonDigits(?string $digit)
    {
        return (string) preg_replace('/[^0-9]/', '', $digit);
    }
}
