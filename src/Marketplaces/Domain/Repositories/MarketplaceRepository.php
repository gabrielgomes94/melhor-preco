<?php

namespace Src\Marketplaces\Domain\Repositories;

use Illuminate\Support\Collection;

interface MarketplaceRepository
{
    public function list(): Collection;
}
