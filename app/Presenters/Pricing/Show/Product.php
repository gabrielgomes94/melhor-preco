<?php

namespace App\Presenters\Pricing\Show;

use Src\Prices\Domain\Price\Models\Price as PriceModel;
use App\Models\Product as ProductModel;

class Product
{
    public string $id;
    public string $sku;
    public string $name;

    /**
     * @var Price[] $prices
     */
    public array $prices;

    public function __construct(ProductModel $model, array $stores)
    {
        $this->id = $model->id;
        $this->sku = $model->sku;
        $this->name = $model->name;
        $this->prices = $this->setPrices($model, $stores);
    }

    private function setPrices(ProductModel $model, array $stores): array
    {
        foreach ($model->prices->all() as $price) {
            if (in_array($price->store, $stores)) {
                $prices[] = new Price($price);
            }
        }

        return $prices ?? [];
    }

    public function isValid(): bool
    {
        return !empty($this->prices);
    }
}
