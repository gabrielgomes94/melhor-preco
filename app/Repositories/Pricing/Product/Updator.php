<?php

namespace App\Repositories\Pricing\Product;

use App\Models\Product as ProductModel;

class Updator
{
    public function update(string $productId, array $data)
    {
        if ($model = ProductModel::find($productId)) {
            $model->purchase_price = $data['purchasePrice'];
            $model->tax_ipi = $data['taxIPI'];
            $model->tax_icms = $data['taxICMS'];
            $model->tax_simples_nacional = $data['taxSimplesNacional'];
            $model->additional_costs = $data['additionalCosts'];

            return $model->save();
        }

        return false;
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
