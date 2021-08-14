<?php

namespace App\Repositories\Product;

use App\Factories\Product\Product as ProductFactory;
use App\Models\Product as ProductModel;
use App\Repositories\Pricing\Product\Filters\Active;
use App\Repositories\Pricing\Product\Filters\Contracts\Filter;
use Barrigudinha\Product\Entities\ProductsCollection;
use Barrigudinha\Product\Repositories\Contracts\Options;

class ListDB extends BaseList
{
    /**
     * @var Filter[] $filters
     */
    protected array $filters = [
        Active::class,
    ];

    protected function get(?Options $options = null): array
    {
        if (!$options || !$options->page()) {
            return ProductModel::whereNull('parent_sku')
                ->get()
                ->sortBy('sku')
                ->all();
        }

        if ($sku = $options->searchSku()) {
            return $this->queryProductsBySku($options);
        }

        return ProductModel::whereNull('parent_sku')
            ->paginate(perPage: $options->perPage(), page: $options->page())
            ->sortBy('sku')
            ->all();
    }

    public function count(?Options $options = null): int
    {
        if ($sku = $options->searchSku()) {
            return $this->countProductsBySku($options);
        }

        return ProductModel::whereNull('parent_sku')->count();
    }

    protected function map(array $products, ?Options $options = null): ProductsCollection
    {
        $products = array_map(function (ProductModel $product) {
            return ProductFactory::buildFromModel($product);
        }, $products);

        return new ProductsCollection($products);
    }

    private function queryProductsBySku(?Options $options = null): array
    {
        $sku = $options?->searchSku();

        return ProductModel::where('sku', $sku)
            ->orWhere('parent_sku', $sku)
            ->orWhere('composition_products', 'like', '%"' . $sku .'"%')
            ->paginate(perPage: $options->perPage(), page: $options->page())
            ->sortBy('product_id')
            ->all();
    }

    private function countProductsBySku(?Options $options = null): int
    {
        $sku = $options?->searchSku();

        return ProductModel::where('sku', $sku)
            ->orWhere('parent_sku', $sku)
            ->orWhere('composition_products', 'like', '%"' . $sku .'"%')
            ->count();
    }
}
