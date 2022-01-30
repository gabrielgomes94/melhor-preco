<?php

namespace Src\Marketplaces\Domain\UseCases\Contracts;

interface CreateMarketplace
{
    public function create(array $data): bool;
}
