<?php

namespace Src\Integrations\Bling\Products\Requests;

class Endpoint
{
    public static function product(string $sku): string
    {
        return "produto/$sku/json/";
    }

    public static function products(int $page): string
    {
        return "produtos/page={$page}/json/";
    }

    public static function productStore(string $sku, string $storeCode): string
    {
        return "produtoLoja/{$storeCode}/{$sku}/json/";
    }
}
