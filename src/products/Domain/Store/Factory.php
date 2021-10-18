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
}
