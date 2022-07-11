<?php

namespace Src\Sales\Infrastructure\Bling\Responses\Transformers;

use Carbon\Carbon;
use Src\Sales\Domain\Models\ValueObjects\SaleIdentifiers;
use Src\Sales\Domain\Models\ValueObjects\SaleDates;
use Src\Sales\Domain\Models\ValueObjects\SaleValue;
use Src\Sales\Infrastructure\Laravel\Models\Address;
use Src\Sales\Infrastructure\Laravel\Models\Customer;
use Src\Sales\Infrastructure\Laravel\Models\Invoice;
use Src\Sales\Infrastructure\Laravel\Models\Item;
use Src\Sales\Infrastructure\Laravel\Models\SaleOrder;
use Src\Sales\Infrastructure\Laravel\Models\Shipment;

class Transformer
{
    public static function transform(array $data)
    {
        $saleOrder = new SaleOrder();
        $saleOrder->identifiers = new SaleIdentifiers(
            id: $data['numero'],
            purchaseOrderId: $data['numeroOrdemCompra'] ?? '',
            integration: $data['tipoIntegracao'] ?? null,
            storeId: $data['loja'] ?? null,
            storeSaleOrderId: $data['numeroPedidoLoja'] ?? null
        );

        $saleOrder->sale_values = new SaleValue(
            discount: (float) $data['desconto'],
            freight: (float) $data['valorfrete'],
            totalProducts: (float) $data['totalprodutos'],
            totalValue: (float) $data['totalvenda']
        );

        $saleOrder->sale_dates = new SaleDates(
            selledAt: Carbon::createFromFormat('Y-m-d', $data['data']),
            dispatchedAt: isset($data['dataSaida'])
                ? Carbon::createFromFormat('Y-m-d', $data['dataSaida'])
                : null,
            expectedArrivalAt: isset($data['dataPrevista'])
                ? Carbon::createFromFormat('Y-m-d', $data['dataPrevista'])
                : null
        );

        $saleOrder->status = $data['situacao'];

        $saleOrder->setRelation('customer', self::makeCustomer($data));
        $saleOrder->setRelation('items', self::makeItems($data));
        $saleOrder->setRelation('invoice', self::makeInvoice($data));
        $saleOrder->setRelation('shipment', self::makeShipment($data));

        return $saleOrder;
    }

    private static function makeCustomer(array $data)
    {
        $address = self::makeAddress($data['cliente']);
        $phones = self::getPhones($data);

        $customer = new Customer([
            'name' => $data['cliente']['nome'] ?? '',
            'fiscal_id' => self::removeNonDigits(
                $data['cliente']['cnpj']
                ?? $data['cliente']['cpf']
                ?? ''
            ),
            'phones' => $phones,
            'document_number' => $data['cliente']['rg'] ?? '',
        ]);

        $customer->setRelation('address', $address);

        return $customer;
    }

    private static function makeInvoice(array $data)
    {
        if (!isset($data['nota'])) {
            return null;
        }

        return new Invoice([
            'series' => $data['nota']['serie'],
            'number' => $data['nota']['numero'],
            'issued_at' => Carbon::createFromFormat('Y-m-d H:i:s', $data['nota']['dataEmissao']),
            'status' => $data['nota']['situacao'],
            'value' => $data['nota']['valorNota'],
            'access_key' => $data['nota']['chaveAcesso'] ?? '',
        ]);
    }

    private static function makeItems(array $data)
    {
        $items = array_map(function (array $item) {
            $item = $item['item'];

            return new Item([
                'sku' => $item['codigo'] ?? '',
                'name' => $item['descricao'],
                'quantity' => $item['quantidade'],
                'unit_value' => $item['valorunidade'],
                'discount' => $item['descontoItem'],
            ]);
        }, $data['itens']);

        return collect($items);
    }

    private static function makeShipment(array $data)
    {
        if (!isset($data['transporte']['enderecoEntrega'])) {
            return null;
        }

        $address = self::makeAddress($data['transporte']['enderecoEntrega']);
        $shipment = new Shipment([
            'name' => $data['transporte']['enderecoEntrega']['nome'] ?? '',
        ]);
        $shipment->setRelation('address', $address);

        return $shipment;
    }

    private static function removeNonDigits(?string $digit)
    {
        return (string) preg_replace('/[^0-9]/', '', $digit);
    }

    private static function makeAddress(array $data): Address
    {
        return new Address([
            'street' => $data['endereco'],
            'number' => $data['numero'],
            'district' => $data['bairro'],
            'city' => $data['cidade'],
            'state' => $data['uf'],
            'zipcode' => $data['cep'],
            'complement' => $data['complemento'] ?? '',
        ]);
    }

    private static function getPhones(array $data): array
    {
        $mainPhone = self::removeNonDigits($data['cliente']['fone'])
            ? ['+55' . self::removeNonDigits($data['cliente']['fone'])]
            : [];

        $secondaryPhone = self::removeNonDigits($data['cliente']['celular'])
            ? ['+55' . self::removeNonDigits($data['cliente']['celular'])]
            : [];

        return array_merge(
            $mainPhone,
            $secondaryPhone
        );
    }
}
