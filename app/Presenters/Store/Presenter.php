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
            name: $this->repository->name($store)
        );

        return $store;
    }
}
