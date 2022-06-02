<?php

namespace Src\Costs\Domain\UseCases\Contracts;

use Src\Products\Application\Exceptions\ProductNotFoundException;

interface UpdateCosts
{
    /**
     * @throws ProductNotFoundException
     */
    public function execute(string $sku, array $data): bool;
}
