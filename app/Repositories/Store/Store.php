<?php

namespace App\Repositories\Store;

use Barrigudinha\Store\Repositories\StoreRepository;

class Store implements StoreRepository
{
    public function all(): array
    {
        $stores = config('stores');

        return array_keys($stores);
    }

    public function erpCode(string $store): string
    {
        return config('stores.' . $store . '.erpCode');
    }

    public function name(string $store): string
    {
        return config('stores.' . $store . '.name');
    }

    public function commission(string $store): string
    {
        return config('stores.' . $store . '.commission');
    }

    public function getNameFromCode(?string $erpCode): string
    {
        $stores = config('stores');

        foreach ($stores as $store) {
            if ($store['erpCode'] === $erpCode) {
                return $store['name'];
            }
        }

        return '';
    }
}
