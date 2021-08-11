<?php

namespace Barrigudinha\Product\Entities;

class ProductsCollection extends BaseIterator
{
    protected function build(array $data = []): array
    {
        foreach ($data as $item) {
            if ($item instanceof Product) {
                $products[] = $item;

                continue;
            }

            throw new \Exception('Invalid product');
        }

        return $products ?? [];
    }
}
