<?php

namespace Src\Products\Domain\Product\Contracts\Models;

use Src\Products\Domain\Store\Store;

interface Post
{
    public function getId(): string;

    public function getCommission(): float;

    public function getPrice(): float;

    public function getProfit(): float;

    public function getStore(): Store;
}
