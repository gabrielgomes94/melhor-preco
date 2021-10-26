<?php

namespace Src\Products\Domain\Product\Contracts\Models\Data\Variations;

interface Variations
{
    public function get(): array;

    public function getParentSku(): ?string;
}
