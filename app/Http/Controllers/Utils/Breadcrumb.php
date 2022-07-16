<?php

namespace App\Http\Controllers\Utils;

class Breadcrumb
{
    public function generate(...$array): array
    {
        foreach ($array as $element) {
            $breadcrumb[] = $element;
        }

        return $breadcrumb ?? [];
    }

    public static function priceListIndex(): array
    {
        return [
            'link' => route('pricing.priceList.byStore'),
            'name' => 'Listas de Preços',
        ];
    }

    public static function priceListByStore(string $storeName, string $storeSlug): array
    {
        return [
            'link' => route('pricing.priceList.byStore', $storeSlug),
            'name' => $storeName,
        ];
    }

    public static function product(string $name): array
    {
        return [
            'name' => $name,
            'link' => '',
        ];
    }
}
