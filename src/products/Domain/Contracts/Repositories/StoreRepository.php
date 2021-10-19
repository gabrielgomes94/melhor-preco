<?php

namespace Src\Products\Domain\Contracts\Repositories;

use Src\Products\Domain\Store\Store;

interface StoreRepository
{
    /**
     * @return Store[]
     */
    public function all(): array;

    public function getFromErpCode(string $erpCode): ?Store;

    public function getFromSlug(string $slug): ?Store;
}
