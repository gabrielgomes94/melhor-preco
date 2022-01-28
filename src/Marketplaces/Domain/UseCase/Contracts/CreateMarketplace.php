<?php

namespace Src\Marketplaces\Domain\UseCase\Contracts;

interface CreateMarketplace
{
    public function create(array $data): bool;
}
