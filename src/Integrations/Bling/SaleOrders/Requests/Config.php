<?php

namespace Src\Integrations\Bling\SaleOrders\Requests;

class Config
{
    public static function listSalesOptions(): array
    {
        return [
            'base_uri' => config('integrations.bling.base_uri'),
            'query' => [
                'apikey' => config('integrations.bling.auth.apikey'),
            ],
        ];
    }

    public static function listSalesUrl(int $page): string
    {
        return "pedidos/page={$page}/json/";
    }
}
