<?php

namespace Src\Products\Domain\Models\Product\Contracts;

use Src\Calculator\Domain\Models\Price\Price;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Products\Domain\Models\Post\Identifiers\Identifiers;

interface Post
{
    public function getId(): string;

    public function getIdentifiers(): Identifiers;

    public function getMarketplace(): Marketplace;

    public function getPrice(): Price;
}
