<?php

namespace App\Repositories\Product;

use App\Factories\Product\Product as ProductFactory;
use App\Models\Product as ProductModel;
use Barrigudinha\Pricing\Repositories\Contracts\ProductFinder;
use Barrigudinha\Product\Product;

class FinderDB implements ProductFinder
{
    /**
     * @return Product[]
     */
    public function all(): array
    {
        $products = array_map(function ($product) {
            return Product::createFromArray($product);
        }, ProductModel::all()->toArray());

        return $products;
    }

    public function get(string $sku): ?Product
    {
        if ($model = $this->findBySku($sku)) {
            return Product::createFromArray($model->toArray());
        }

        return null;
    }

    public function getById(string $id): ?Product
    {
        if ($model = ProductModel::find($id)) {
            return ProductFactory::buildFromModel($model);
        }

        return null;
    }

    private function findBySku(string $sku): ?ProductModel
    {
        return ProductModel::where('sku', $sku)->first();
    }
}
