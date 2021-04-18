<?php

namespace App\Repositories\Pricing;

use App\Models\PriceCampaign;
use App\Models\Pricing as PricingModel;
use App\Models\Product as ProductModel;
use Barrigudinha\Pricing\Data\Pricing;
use Barrigudinha\Pricing\Data\Product;
use Barrigudinha\Pricing\Repositories\Contracts\Pricing as PricingRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PricingRepository implements PricingRepositoryInterface
{
    public function create(Pricing $pricing): bool
    {
        $pricingModel = new PricingModel();

        $pricingModel->name = $pricing->name;
        $pricingModel->stores = $pricing->stores;
        $pricingModel->save();

        foreach ($pricing->products as $product) {
            $productModel = ProductModel::where('sku', $product->sku())->first();
            $pricingModel->products()->save($productModel);
        }

        return $pricingModel->save();
    }

    public function all(): Collection
    {
        return PricingModel::all();
    }

    public function find(string $id): ?PricingModel
    {
        return PricingModel::find($id);
    }
}
