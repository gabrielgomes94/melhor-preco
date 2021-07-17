<?php

namespace App\Presenters\Store;

use App\Repositories\Store\Store as StoreRepository;

class Presenter
{
    private StoreRepository $repository;

    public function __construct(StoreRepository $repository)
    {
        $this->repository = $repository;
    }

    public function present(string $store): Store
    {
        $store = new Store(
            name: $this->repository->name($store),
            slug: $store
        );

        return $store;
    }

    /**
     * @param string[] $stores
     * @return array
     */
    public function list(array $stores): array
    {
        return array_map(function(string $store) {
            return new Store(
                name: $this->repository->name($store),
                slug: $store
            );
        }, $stores);
    }
}
