<?php

namespace Src\Products\Domain\Product\Contracts\Models\Data\Variations;

interface Variations
{
    /**
     * @return \Src\Products\Domain\Entities\Product[]
     */
    public function get(): array;
}
