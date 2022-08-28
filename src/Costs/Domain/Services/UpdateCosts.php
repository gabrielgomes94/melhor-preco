<?php

namespace Src\Costs\Domain\Services;

use Src\Products\Domain\Exceptions\ProductNotFoundException;

interface UpdateCosts
{
    /**
     * @throws ProductNotFoundException
     */
    public function execute(string $sku, array $data, string $userId): bool;
}
