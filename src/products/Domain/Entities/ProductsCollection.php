<?php

namespace Src\Products\Domain\Entities;

use Src\Products\Domain\Entities\BaseIterator;
use Src\Products\Domain\Entities\Product;

class ProductsCollection extends BaseIterator
{
    protected function build(array $data = []): array
    {
        foreach ($data as $item) {
            if ($item instanceof Product) {
                $products[] = $item;

                continue;
            }

            $products[] = $item;
        }

        return $products ?? [];
    }
}
