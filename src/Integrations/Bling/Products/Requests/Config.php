<?php

namespace Src\Integrations\Bling\Products\Requests;

class Config
{
    public const ACTIVE = 'active';
    public const INACTIVE = 'inactive';

    public static function getPrice(string $storeCode, string $status = self::ACTIVE): array
    {
        $status = self::transformStatus($status);

        return [
            'base_uri' => config('integrations.bling.products.get.base_uri'),
            'query' => [
                'apikey' => config('integrations.bling.auth.apikey'),
                'estoque' => 'S',
                'filters' => "situacao[$status]",
                'imagem' => 'S',
                'loja' => $storeCode,
            ],
        ];
    }

    public static function getProduct(string $status = self::ACTIVE): array
    {
        $status = self::transformStatus($status);

        return [
            'base_uri' => config('integrations.bling.products.get.base_uri'),
            'query' => [
                'apikey' => config('integrations.bling.auth.apikey'),
                'filters' => "situacao[$status]",
                'estoque' => 'S',
                'imagem' => 'S',
            ],
        ];
    }

    public static function listProducts(string $status = self::ACTIVE, ?string $storeCode = null): array
    {
        $status = self::transformStatus($status);

        return [
            'base_uri' => config('integrations.bling.products.list.base_uri'),
            'query' => [
                'apikey' => config('integrations.bling.auth.apikey'),
                'estoque' => 'S',
                'filters' => "situacao[$status]",
                'imagem' => 'S',
                'loja' => $storeCode,
            ],
        ];
    }

    public static function updatePrice(string $xml): array
    {
        return [
            'base_uri' => config('integrations.bling.products.updatePrice.base_uri'),
            'headers' => [
                'Content-Type' => 'text/xml',
            ],
            'query' => [
                'apikey' => config('integrations.bling.auth.apikey'),
                'xml' => $xml,
            ],
        ];
    }

    public static function updateProduct(string $xml): array
    {
        return [
            'base_uri' => config('integrations.bling.products.updateProduct.base_uri'),
            'headers' => [
                'Content-Type' => 'text/xml',
            ],
            'query' => [
                'apikey' => config('integrations.bling.auth.apikey'),
                'xml' => $xml,
            ],
        ];
    }

    private static function transformStatus(string $status): string
    {
        return $status == self::ACTIVE
            ? 'A'
            : 'I';
    }
}
