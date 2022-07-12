<?php

namespace Src\Integrations\Bling\SaleOrders\Requests;

class Config
{
    public static function listSalesOptions(string $erpToken): array
    {
        return [
            'base_uri' => config('integrations.bling.base_uri'),
            'query' => [
                'apikey' => $erpToken,
            ],
        ];
    }

    public static function listSalesUrl(int $page): string
    {
        return "pedidos/page={$page}/json/";
    }
}
