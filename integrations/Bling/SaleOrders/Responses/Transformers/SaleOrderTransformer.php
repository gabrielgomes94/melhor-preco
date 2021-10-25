<?php

namespace Integrations\Bling\SaleOrders\Responses\Transformers;

use Src\Sales\Domain\Models\SaleOrder;
use Src\Sales\Application\Factories\SaleOrder as SaleOrderFactory;
use Carbon\Carbon;

class SaleOrderTransformer
{
    public static function transform(array $data): SaleOrder
    {
        $transformed = [
            'identifiers' => self::getIdentifiers($data),
            'saleValue' => self::getSaleValue($data),
            'saleDates' => self::getSaleDates($data),
            'status' => $data['situacao'],
            'customer' => self::getCustomer($data),
            'invoice' => self::getInvoice($data),
            'items' => self::getItems($data['itens']),
            'payment' => self::getPaymentInstallments($data),
            'shipment' => self::getShipment($data),
        ];

        return SaleOrderFactory::make($transformed);
    }

    private static function getCustomer(array $data): array
    {
        return [
            'name' => $data['cliente']['nome'],
            'fiscalId' => $data['cliente']['cnpj'] ?? $data['cliente']['cpf'],
            'stateRegistration' => $data['cliente']['ie'],
            'documentNumber' => $data['cliente']['rg'],
            'email' => $data['cliente']['email'],
            'address' => [
                'street' => $data['cliente']['endereco'],
                'number' => $data['cliente']['numero'],
                'complement' => $data['cliente']['complemento'],
                'district' => $data['cliente']['bairro'],
                'city' => $data['cliente']['cidade'],
                'state' => $data['cliente']['uf'],
                'zipcode' => $data['cliente']['cep'],
            ],
            'phones' => [
                $data['cliente']['fone'],
                $data['cliente']['celular'],
            ]
        ];
    }

    private static function getIdentifiers(array $data): array
    {
        return [
            'id' => $data['numero'],
            'purchaseOrderId' => $data['numeroOrdemCompra'],
            'storeId' => $data['loja'] ?? null,
            'storeSaleOrderId' => $data['numeroPedidoLoja'] ?? null,
            'integration' => $data['tipoIntegracao'] ?? null,
        ];
    }

    private static function getInvoice(array $data): array
    {
        if (!isset($data['nota'])) {
            return [];
        }

        return [
            'series' => $data['nota']['serie'],
            'number' => $data['nota']['numero'],
            'issuedAt' => Carbon::createFromFormat('Y-m-d H:i:s', $data['nota']['dataEmissao']),
            'status' => $data['nota']['situacao'],
            'value' => $data['nota']['valorNota'],
            'accessKey' => $data['nota']['chaveAcesso'],
        ];
    }

    private static function getItems(array $data): array
    {
        return array_map(function (array $item) {
            return [
                'sku' => $item['item']['codigo'],
                'name' => $item['item']['descricao'],
                'quantity' => $item['item']['quantidade'],
                'unitValue' => $item['item']['valorunidade'],
                'discount' => $item['item']['descontoItem'],
            ];
        }, $data);
    }

    private static function getPaymentInstallments(array $data): array
    {
        if (!isset($data['parcelas'])) {
            return [];
        }

        return array_map(function (array $paymentInstallment) {
            return [
                'id' => $paymentInstallment['parcela']['idLancamento'],
                'value' => $paymentInstallment['parcela']['valor'],
                'expiresAt' => Carbon::createFromFormat(
                    'Y-m-d H:i:s',
                    $paymentInstallment['parcela']['dataVencimento']
                ),
                'observation' => $paymentInstallment['parcela']['obs'],
                'destination' => $paymentInstallment['parcela']['destino'],
            ];
        }, $data['parcelas']);
    }

    private static function getSaleDates(array $data): array
    {
        return [
            'selledAt' => Carbon::createFromFormat('Y-m-d', $data['data']),
            'dispatchedAt' => isset($data['dataSaida'])
                ? Carbon::createFromFormat('Y-m-d', $data['dataSaida'])
                : null,
            'expectedArrivalAt' => isset($data['dataPrevista'])
                ? Carbon::createFromFormat('Y-m-d', $data['dataPrevista'])
                : null,
        ];
    }

    private static function getSaleValue(array $data): array
    {
        return [
            'discount' => (float) $data['desconto'],
            'freight' => (float) $data['valorfrete'],
            'totalProducts' => (float) $data['totalprodutos'],
            'totalValue' => (float) $data['totalvenda'],
        ];
    }

    private static function getShipment(array $data): array
    {
        if (!isset($data['transporte'])) {
            return [];
        }

        return [
            'name' => $data['transporte']['enderecoEntrega']['nome'],
            'address' => [
                'street' => $data['transporte']['enderecoEntrega']['endereco'],
                'number' => $data['transporte']['enderecoEntrega']['numero'],
                'complement' => $data['transporte']['enderecoEntrega']['complemento'],
                'district' => $data['transporte']['enderecoEntrega']['bairro'],
                'city' => $data['transporte']['enderecoEntrega']['cidade'],
                'state' => $data['transporte']['enderecoEntrega']['uf'],
                'zipcode' => $data['transporte']['enderecoEntrega']['cep'],
            ],
        ];
    }
}
