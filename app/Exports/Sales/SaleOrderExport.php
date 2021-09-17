<?php

namespace App\Exports\Sales;

use Maatwebsite\Excel\Concerns\FromArray;

class SaleOrderExport implements FromArray
{
    private array $saleOrders;

    public function __construct(array $saleOrders)
    {
        $this->saleOrders = $saleOrders;
    }

    public function array(): array
    {
        $firstRow = [
            'Pedido',
            'ID do Pedido na Loja',
            'Data de Venda',
            'Loja',
            'Status',
            'Produtos',
            'Valor',
            'Lucro',
        ];

        $saleOrders = array_map(function (array $saleOrder) {
            return [
                $saleOrder['saleOrderCode'] ?? '',
                $saleOrder['storeSaleOrderId'] ?? '',
                $saleOrder['selledAt'] ?? '',
                $saleOrder['store'] ?? '',
                $saleOrder['status'] ?? '',
                implode('\n', $saleOrder['products'] ?? []),
                $saleOrder['value'] ?? '',
                $saleOrder['profit'] ?? '',
            ];
        }, $this->saleOrders['saleOrders']);

        return array_merge([$firstRow], $saleOrders);
    }
}