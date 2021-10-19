<?php

namespace Src\Products\Infrastructure\Repositories;

use Src\Products\Domain\Contracts\Repositories\StoreRepository as StoreRepostioryInterface;
use Src\Products\Domain\Store\Store;

class StoreRepository implements StoreRepostioryInterface
{
    public function all(): array
    {
        $stores = config('stores');

        foreach ($stores as $store) {
            $storesCollection[] = $this->makeStore($store);
        }

        return $storesCollection ?? [];
    }

    public function getFromErpCode(string $erpCode): ?Store
    {
        $stores = config('stores');

        foreach ($stores as $store) {
            if ($store['erpCode'] === $erpCode) {
                return $this->makeStore($store);
            }
        }

        return null;
    }

    public function getFromSlug(string $slug): ?Store
    {
        $store = config('stores.' . $slug);

        if (!$store) {
            return null;
        }

        return $this->makeStore($store);
    }

    private function makeStore(array $data): Store
    {
        return new Store(
            slug: $data['slug'],
            name: $data['name'],
            erpCode: $data['erpCode'],
            defaultCommission: $data['commission']
        );
    }
}
