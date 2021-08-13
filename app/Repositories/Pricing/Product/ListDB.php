<?php

namespace App\Repositories\Pricing\Product;

use App\Factories\Product\Product as ProductFactory;
use App\Models\Product as ProductModel;
use App\Repositories\Pricing\Product\Filters\Active;
use App\Repositories\Pricing\Product\Filters\Contracts\Filter;
use App\Repositories\Pricing\Product\Filters\Kit;
use App\Repositories\Pricing\Product\Filters\MarginRange;
use App\Repositories\Product\BaseList;
use Barrigudinha\Product\Entities\ProductsCollection;
use Barrigudinha\Product\Repositories\Contracts\Options;

class ListDB extends BaseList
{
    /**
     * @var Filter[] $filters
     */
    protected array $filters = [
        Active::class,
        Kit::class,
        MarginRange::class,
    ];

    public function count(?Options $options = null): int
    {
        if (!$options) {
            return 0;
        }

        if ($options->filterKits()) {
            return $this->countCompositionProducts($options);
        }

        return $this->countProducts($options);
    }

    protected function get(?Options $options = null): array
    {
        if ($options->filterKits()) {
            return $this->queryCompositionProducts($options);
        }

        return $this->queryProducts($options);
    }

    protected function map(array $products, Options $options): ProductsCollection
    {
        $products = array_map(function (ProductModel $product) {
            return ProductFactory::buildWithPrice($product);
        }, $products);

        return new ProductsCollection($products);
    }

    private function countCompositionProducts(?Options $options = null): int
    {
        $store = $options?->store();

        return ProductModel::leftJoin('prices', 'prices.product_id', '=', 'products.id')
            ->whereNull('parent_sku')
            ->whereNotNull('product_id')
            ->whereNotIn('composition_products', ['[]'])
            ->where('store', $store)
            ->count();
    }

    private function countProducts(?Options $options = null)
    {
        $store = $options?->store();

        return ProductModel::leftJoin('prices', 'prices.product_id', '=', 'products.id')
            ->whereNull('parent_sku')
            ->whereNotNull('product_id')
            ->where('store', $store)
            ->count();
    }

    private function queryCompositionProducts(?Options $options = null): array
    {
        $store = $options?->store();

        return ProductModel::leftJoin('prices', 'prices.product_id', '=', 'products.id')
            ->whereNull('parent_sku')
            ->whereNotNull('product_id')
            ->whereNotIn('composition_products', ['[]'])
            ->where('store', $store)
            ->paginate(perPage: $options->perPage(), page: $options->page())
            ->sortBy('product_id')
            ->all();
    }

    private function queryProducts(?Options $options = null): array
    {
        $store = $options?->store();

        return ProductModel::leftJoin('prices', 'prices.product_id', '=', 'products.id')
            ->whereNull('parent_sku')
            ->whereNotNull('product_id')
            ->where('store', $store)
            ->paginate(perPage: $options->perPage(), page: $options->page())
            ->sortBy('product_id')
            ->all();
    }
}
