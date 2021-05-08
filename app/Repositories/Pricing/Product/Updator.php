<?php

namespace App\Repositories\Pricing\Product;

use App\Models\Product as ProductModel;

class Updator
{
    public function update(string $productId, array $data)
    {
        if (!$model = ProductModel::find($productId)) {
            return false;
        }

        $model->purchase_price = $data['purchasePrice'];
        $model->tax_icms = $data['taxICMS'];
        $model->tax_simples_nacional = config('taxes.simples_nacional');
        $model->additional_costs = $data['additionalCosts'];
        $model->depth = $data['depth'];
        $model->height = $data['height'];
        $model->width = $data['width'];

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
