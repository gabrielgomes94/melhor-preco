<?php

namespace Src\Promotions\Infrastructure\Laravel\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Src\Promotions\Domain\Data\Entities\Promotion;

class PromotionSpredsheet implements FromCollection, WithCustomStartCell
{
    public function __construct(private Promotion $promotion)
    {}

    public function collection(): Collection
    {
        $products = $this->promotion->getProducts();

        foreach ($products as $product) {
            $collection[] = [$product['store_sku_id']];
        }

        return new Collection($collection ?? []);
    }

    public function startCell(): string
    {
        return 'A3';
    }
}
