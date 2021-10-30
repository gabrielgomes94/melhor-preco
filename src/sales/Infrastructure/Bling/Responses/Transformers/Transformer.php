<?php

namespace Src\Sales\Infrastructure\Bling\Responses\Transformers;

use Src\Sales\Domain\Models\Address;
use Src\Sales\Domain\Models\Customer;
use Carbon\Carbon;
use Src\Sales\Domain\Models\Invoice;
use Src\Sales\Domain\Models\Item;
use Src\Sales\Domain\Models\PaymentInstallment;
use Src\Sales\Domain\Models\SaleOrder;
use Src\Sales\Domain\Models\Shipment;

class Transformer
{
    public static function transform(array $data)
    {
        $model = new SaleOrder([
            'sale_order_id' => $data['numero'],
            'purchase_order_id' => $data['numeroOrdemCompra'],
            'store_id' => $data['loja'] ?? null,
            'store_sale_order_id' => $data['numeroPedidoLoja'] ?? null,
            'integration' => $data['tipoIntegracao'] ?? null,
            'discount' => (float) $data['desconto'],
            'freight' => (float) $data['valorfrete'],
            'total_products' => (float) $data['totalprodutos'],
            'total_value' => (float) $data['totalvenda'],
            'selled_at' => Carbon::createFromFormat('Y-m-d', $data['data']),
            'dispatched_at' => isset($data['dataSaida'])
                ? Carbon::createFromFormat('Y-m-d', $data['dataSaida'])
                : null,
            'expected_arrival_at' => isset($data['dataPrevista'])
                ? Carbon::createFromFormat('Y-m-d', $data['dataPrevista'])
                : null,
            'status' => $data['situacao'],
        ]);

        $model->customer = self::makeCustomerModel($data);
        $model->invoice = self::makeInvoiceModel($data);
        $model->shipment = self::makeShipmentModel($data);
        $model->payment = self::makePaymentModels($data);
        $model->items = self::makeItemsModels($data['itens']);

        return $model;
    }

    private static function makeCustomerModel(array $data)
    {
        $customer = new Customer([
            'name' => $data['cliente']['nome'],
            'fiscal_id' => $data['cliente']['cnpj'] ?? $data['cliente']['cpf'],
            'state_registration' => $data['cliente']['ie'],
            'document_number' => $data['cliente']['rg'],
            'email' => $data['cliente']['email'],
            'phones' => [
                $data['cliente']['fone'],
                $data['cliente']['celular'],
            ]
        ]);

        $customer->address = new Address([
            'street' => $data['cliente']['endereco'],
            'number' => $data['cliente']['numero'],
            'complement' => $data['cliente']['complemento'],
            'district' => $data['cliente']['bairro'],
            'city' => $data['cliente']['cidade'],
            'state' => $data['cliente']['uf'],
            'zipcode' => $data['cliente']['cep'],
        ]);

        return $customer;
    }

    private static function makeInvoiceModel(array $data)
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
            'access_key' => $data['nota']['chaveAcesso'],
        ]);
    }

    private static function makeItemsModels(array $data)
    {
        return array_map(function (array $item) {
            return new Item([
                'sku' => $item['item']['codigo'],
                'name' => $item['item']['descricao'],
                'quantity' => $item['item']['quantidade'],
                'unit_value' => $item['item']['valorunidade'],
                'discount' => $item['item']['descontoItem'],
            ]);
        }, $data);
    }

    private static function makeShipmentModel(array $data)
    {
        if (!isset($data['transporte'])) {
            return [];
        }

        $shipment = new Shipment([
            'name' => $data['transporte']['enderecoEntrega']['nome'] ?? '',
        ]);

        $shipment->address = new Address([
            'street' => $data['transporte']['enderecoEntrega']['endereco'],
            'number' => $data['transporte']['enderecoEntrega']['numero'],
            'complement' => $data['transporte']['enderecoEntrega']['complemento'],
            'district' => $data['transporte']['enderecoEntrega']['bairro'],
            'city' => $data['transporte']['enderecoEntrega']['cidade'],
            'state' => $data['transporte']['enderecoEntrega']['uf'],
            'zipcode' => $data['transporte']['enderecoEntrega']['cep'],
        ]);

        return $shipment;
    }

    private static function makePaymentModels(array $data)
    {
        if (!isset($data['parcelas'])) {
            return [];
        }

        return array_map(function (array $paymentInstallment) {

            return new PaymentInstallment([
                'id' => $paymentInstallment['parcela']['idLancamento'],
                'value' => $paymentInstallment['parcela']['valor'],
                'expires_at' => Carbon::createFromFormat(
                    'Y-m-d H:i:s',
                    $paymentInstallment['parcela']['dataVencimento']
                ),
                'observation' => $paymentInstallment['parcela']['obs'],
                'destination' => $paymentInstallment['parcela']['destino'],
            ]);
        }, $data['parcelas']);

        return $payment;
    }
}
