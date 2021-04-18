<?php


namespace App\Repositories\Pricing;


use App\Models\Product as ProductModel;

class UpdateProductRepository
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
}
