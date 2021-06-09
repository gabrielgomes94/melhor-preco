<?php

namespace App\Repositories\Pricing\Product;

use App\Models\Product as ProductModel;
use Barrigudinha\Product\Product;

class Updator
{
    public function update(string $productId, array $data)
    {
        if (!$model = ProductModel::find($productId)) {
            return false;
        }

        $model->purchase_price = $data['purchasePrice'];
        $model->tax_icms = $data['taxICMS'];
        $model->additional_costs = $data['additionalCosts'];

        if (isset($data['depth'])) {
            $model->depth = $data['depth'];
        }
        if (isset($data['height'])) {
            $model->depth = $data['height'];
        }
        if (isset($data['width'])) {
            $model->depth = $data['width'];
        }

        return $model->save();
    }

    public function updateICMS(string $sku, float $taxICMS): bool
    {
        if ($model = ProductModel::where('sku', $sku)->first()) {
            $model->tax_icms = $taxICMS;

            return $model->save();
        }

        return false;
    }
}
