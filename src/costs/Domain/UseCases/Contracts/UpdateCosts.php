<?php

namespace Src\Costs\Domain\UseCases\Contracts;

interface UpdateCosts
{
    public function execute(string $sku, array $data): bool;
}
