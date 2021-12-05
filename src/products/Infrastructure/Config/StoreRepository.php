<?php

namespace Src\Products\Infrastructure\Config;

use Src\Products\Domain\Models\Store\Store;

class StoreRepository
{
    public static function all(): array
    {
        $stores = config('stores');

        foreach ($stores as $store) {
            $storeList[] = new Store(
                slug: $store['slug'],
                name: $store['name'],
                erpCode: $store['erpCode'],
                defaultCommission: $store['commission']
            );
        }

        return $storeList ?? [];
    }
}
