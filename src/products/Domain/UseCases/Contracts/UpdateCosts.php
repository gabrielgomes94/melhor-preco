<?php

namespace Src\Products\Domain\UseCases\Contracts;

interface UpdateCosts
{
    public function execute(string $sku, array $data): bool;
}
