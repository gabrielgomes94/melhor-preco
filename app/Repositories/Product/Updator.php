<?php

namespace App\Repositories\Product;

use App\Models\Product as ProductModel;
use Barrigudinha\Product\Entities\Product;

class Updator
{
    private GetDB $repository;

    public function __construct(GetDB $repository)
    {
        $this->repository = $repository;
    }

    public function update(Product $product, ?ProductModel $model = null)
    {
        if (!$model) {
            $model = $this->repository->getModel($product->sku());
        }

        $model->erp_id = $product->erpId();
        $model->purchase_price = $product->costs()->purchasePrice();
        $model->additional_costs = $product->costs()->additionalCosts();
        $model->tax_icms = $product->costs()->taxICMS();
        $model->name = $product->name();
        $model->brand = $product->brand();
        $model->depth = $product->dimensions()->depth();
        $model->height = $product->dimensions()->height();
        $model->width = $product->dimensions()->width();
        $model->weight = $product->dimensions()->weight();
        $model->parent_sku = $product->parentSku();
        $model->has_variations = $product->hasVariations();

        if (!$composition = $product->compositionProducts()) {
            $model->composition_products = [];
        }

        $model->composition_products = $composition;
        $model->is_active = $product->isActive();

        return $model->save();
    }

    public function updateCosts(Product $product): bool
    {
        if (!$model = $this->repository->getModel($product->sku())) {
            return false;
        }

        $model->purchase_price = $product->costs()->purchasePrice();
        $model->additional_costs = $product->costs()->additionalCosts();
        $model->tax_icms = $product->costs()->taxICMS();

        return $model->save();
    }
}
