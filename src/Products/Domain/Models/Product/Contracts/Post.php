<?php

namespace Src\Products\Domain\Models\Product\Contracts;

use Src\Calculator\Domain\Models\Price\Price as CalculatedPrice;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Prices\Domain\Models\Price;
use Src\Products\Domain\Models\Post\Identifiers\Identifiers;

interface Post
{
    public function getId(): string;

    public function getIdentifiers(): Identifiers;

    public function getMarketplace(): Marketplace;

    public function getProduct(): Product;

    public function getPrice(): Price;

    public function getCalculatedPrice(): CalculatedPrice;
}
