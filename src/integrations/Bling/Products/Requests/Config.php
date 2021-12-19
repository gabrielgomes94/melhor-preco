<?php

namespace Src\Integrations\Bling\Products\Requests;

class Config
{
    public const ACTIVE = 'active';
    public const INACTIVE = 'inactive';

    public static function getProduct(string $status = self::ACTIVE, ?string $storeCode = null): array
    {
        $status = self::transformStatus($status);

        if (!$storeCode) {
            return array_merge_recursive(
                config('integrations.bling.endpoints.products.get'),
                [
                    'query' => [
                        'filters' => "situacao[{$status}]",
                    ],
                ]
            );
        }

        return array_merge_recursive(
            config('integrations.bling.endpoints.products.get'),
            [
                'query' => [
                    'loja' => $storeCode,
                    'filters' => "situacao[{$status}]",
                ],
            ]
        );
    }

    public static function listProducts(string $status = self::ACTIVE, ?string $storeCode = null): array
    {
        $status = self::transformStatus($status);

        return array_merge_recursive(
            config('integrations.bling.endpoints.products.list'),
            [
                'query' => [
                    'loja' => $storeCode,
                    'filters' => "situacao[{$status}]",
                ],
            ]
        );
    }

    public static function listSupplierProducts(string $status = self::ACTIVE, ?string $storeCode = null): array
    {
//        $status = self::transformStatus($status);

        return array_merge_recursive(
            config('integrations.bling.endpoints.productsSupplier.list'),
            [
                'query' => [
//                    'loja' => $storeCode,
//                    'filters' => "situacao[{$status}]",
                ],
            ]
        );
    }

    public static function updateProduct(string $xml): array
    {
        return array_merge_recursive(
            config('integrations.bling.endpoints.products.update'),
            [
                'query' => [
                    'xml' => $xml,
                ],
            ]
        );
    }

    private static function transformStatus(string $status): string
    {
        return $status == self::ACTIVE
            ? 'A'
            : 'I';
    }
}
