<?php

namespace Src\Products\Domain\Product\Contracts\Models\Data\Price;

interface Identifiers
{
    public function getId(): string;

    public function getStoreSkuId(): string;
}
