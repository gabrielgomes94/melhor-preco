<?php

namespace Src\Products\Domain\Models\Post\Contracts;

use Src\Prices\Domain\Models\Calculator\Contracts\CalculatedPrice as CalculatedPrice;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Prices\Infrastructure\Laravel\Models\Price;
use Src\Products\Domain\Models\Post\Identifiers\Identifiers;
use Src\Products\Domain\Models\Product\Product;

interface Post
{
    public function getId(): string;

    public function getIdentifiers(): Identifiers;

    public function getMarketplace(): Marketplace;

    public function getProduct(): Product;

    public function getPrice(): Price;

    public function getCalculatedPrice(): CalculatedPrice;
}
