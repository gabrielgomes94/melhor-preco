<?php

namespace Src\Products\Domain\Repositories\Contracts;

use Src\Products\Domain\Models\Store\Store;

interface StoreRepository
{
    /**
     * @return Store[]
     */
    public function all(): array;

    public function getFromErpCode(string $erpCode): ?Store;

    public function getFromSlug(string $slug): ?Store;
}
