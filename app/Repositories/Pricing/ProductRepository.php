<?php


namespace App\Repositories\Pricing;

use App\Models\Product;
use Barrigudinha\Pricing\Data\Product as ProductData;
use Barrigudinha\Pricing\Repositories\Contracts\Product as RepositoryContract;

class ProductRepository implements RepositoryContract
{
    public function get(string $sku): ?ProductData
    {
        $model = Product::where('sku', $sku)->first();

        if (!$model) {
            return null;
        }

        return new ProductData($model->toArray());
    }
}
