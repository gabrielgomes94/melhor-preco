<?php

namespace Src\Costs\Domain\UseCases;

interface UpdateCosts
{
    public function execute(string $sku, array $data): bool;
}
