<?php

namespace Src\Products\Domain\Models\Product\Contracts;

use Src\Calculator\Domain\Models\Price\Price;
use Src\Products\Domain\Models\Post\Identifiers\Identifiers;
use Src\Products\Domain\Models\Store\Store;

interface Post
{
    public function getId(): string;

    public function getIdentifiers(): Identifiers;

    public function getPrice(): Price;

    public function getStore(): Store;
}
