<?php

namespace Src\Products\Domain\Store;

class Factory
{
    public static function make(string $slug): Store
    {
        $data = config('stores.' . $slug);

        return new Store(
            slug: $data['slug'],
            name: $data['name'],
            erpCode: $data['erpCode'],
            defaultCommission: $data['commission']
        );
    }

    public static function makeFromErpCode(string $erpCode): ?Store
    {
        $stores = config('stores');

        foreach ($stores as $store) {
            if ($store['erpCode'] === $erpCode) {
                return new Store(
                    slug: $store['slug'],
                    name: $store['name'],
                    erpCode: $store['erpCode'],
                    defaultCommission: $store['commission']
                );
            }
        }

        return null;
    }
}
