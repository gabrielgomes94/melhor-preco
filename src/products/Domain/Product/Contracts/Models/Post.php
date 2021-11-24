<?php

namespace Src\Products\Domain\Product\Contracts\Models;

use Src\Prices\Calculator\Domain\Models\Price\Price;
use Src\Products\Domain\Post\Identifiers\Identifiers;
use Src\Products\Domain\Store\Store;

interface Post
{
    public function getId(): string;

    public function getIdentifiers(): Identifiers;

    public function getPrice(): Price;

    public function getStore(): Store;
}
