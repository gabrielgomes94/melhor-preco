<?php

namespace App\Http\Controllers\Utils;

use Barrigudinha\Pricing\PriceList\PriceList;

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
            'link' => route('pricing.priceList.index'),
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

    public static function priceListCustom(PriceList $priceList): array
    {
        return [
            'name' => $priceList->name(),
            'link' => route('pricing.priceList.custom.show', [$priceList->id()])
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
