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
            'base_uri' => config('integrations.bling.base_uri'),
            'query' => [
                'apikey' => config('integrations.bling.auth.apikey'),
                'estoque' => 'S',
                'filters' => "situacao[$status]",
                'imagem' => 'S',
                'loja' => $storeCode,
            ],
        ];
    }

    public static function getProduct(string $erpToken, string $status = self::ACTIVE): array
    {
        $status = self::transformStatus($status);

        return [
            'base_uri' => config('integrations.bling.base_uri'),
            'query' => [
                'apikey' => $erpToken,
                'filters' => "situacao[$status]",
                'estoque' => 'S',
                'imagem' => 'S',
            ],
        ];
    }



    public static function listProducts(string $erpToken, string $status = self::ACTIVE): array
    {
        $status = self::transformStatus($status);

        return [
            'base_uri' => config('integrations.bling.base_uri'),
            'query' => [
                'apikey' => $erpToken,
                'estoque' => 'S',
                'filters' => "situacao[$status]",
                'imagem' => 'S'
            ],
        ];
    }



    public static function listPrices(string $erpToken, string $status = self::ACTIVE, ?string $storeCode = null): array
    {
        $status = self::transformStatus($status);

        return [
            'base_uri' => config('integrations.bling.base_uri'),
            'query' => [
                'apikey' => $erpToken,
                'filters' => "situacao[$status]",
                'loja' => $storeCode,
            ],
        ];
    }

    public static function updatePrice(string $erpToken, string $xml): array
    {
        return [
            'base_uri' => config('integrations.bling.base_uri'),
            'headers' => [
                'Content-Type' => 'text/xml',
            ],
            'query' => [
                'apikey' => $erpToken,
                'xml' => $xml,
            ],
        ];
    }

    public static function updateProduct(string $erpToken, string $xml): array
    {
        return [
            'base_uri' => config('integrations.bling.base_uri'),
            'headers' => [
                'Content-Type' => 'text/xml',
            ],
            'query' => [
                'apikey' => $erpToken,
                'xml' => $xml,
            ],
        ];
    }

    private static function transformStatus(string $status): string
    {
        return $status == self::ACTIVE ? 'A' : 'I';
    }
}
