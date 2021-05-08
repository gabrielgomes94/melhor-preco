<?php

namespace App\Repositories\Pricing\Product;

use App\Models\Product as ProductModel;
use Barrigudinha\Pricing\Data\Product;
use Barrigudinha\Pricing\Repositories\Contracts\ProductFinder;
use Illuminate\Support\Collection;

class FinderDB implements ProductFinder
{
    /**
     * @return Product[]
     */
    public function all(): array
    {
        $products = array_map(function($product) {
            return new Product($product);
        }, ProductModel::all()->toArray());

        return $products;
    }

    public function get(string $sku): ?Product
    {
        if ($model = $this->findBySku($sku)) {
            return new Product($model->toArray());
        }

        return null;
    }

    public function getById(string $id): ?Product
    {
        if ($model = ProductModel::find($id)) {
            return new Product($model->toArray(), $model->prices->toArray());
        }

        return null;
    }

    private function findBySku(string $sku): ?ProductModel
    {
        return ProductModel::where('sku', $sku)->first();
    }
}
