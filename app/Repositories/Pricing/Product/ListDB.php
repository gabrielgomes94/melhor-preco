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

    protected function getProducts(?Options $options = null): array
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

    public function count(?Options $options = null): int
    {
        if (!$options) {
            return 0;
        }

        $store = $options?->store();

        return ProductModel::leftJoin('prices', 'prices.product_id', '=', 'products.id')
            ->whereNull('parent_sku')
            ->whereNotNull('product_id')
            ->where('store', $store)
            ->count();
    }

    protected function mapProducts(array $products, Options $options): ProductsCollection
    {
        $products = array_map(function (ProductModel $product) {
            return ProductFactory::buildWithPrice($product);
        }, $products);

        return new ProductsCollection($products);
    }
}
