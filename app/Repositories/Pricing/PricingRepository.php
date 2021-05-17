<?php

namespace App\Repositories\Pricing;

use App\Factories\Pricing as PricingFactory;
use App\Models\Pricing as PricingModel;
use App\Models\Product as ProductModel;
use Barrigudinha\Pricing\Data\Pricing;
use Barrigudinha\Pricing\Data\Product;
use Barrigudinha\Pricing\Data\Product as PricingProduct;
use Barrigudinha\Pricing\Repositories\Contracts\Pricing as PricingRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PricingRepository implements PricingRepositoryInterface
{
    private PricingFactory $factory;

    public function __construct(PricingFactory $factory)
    {
        $this->factory = $factory;
    }

    public function create(Pricing $pricing): bool
    {
        $pricingModel = new PricingModel();

        $pricingModel->name = $pricing->name;
        $pricingModel->stores = $pricing->stores;
        $pricingModel->save();

        foreach ($pricing->products as $product) {
            if ($productModel = ProductModel::where('sku', $product->sku())->first()) {
                $pricingModel->products()->save($productModel);
            }
        }

        return $pricingModel->save();
    }

    public function all(): Collection
    {
        return PricingModel::all();
    }

    /**
     * @deprecated
     */
    public function find(string $id): ?PricingModel
    {
        return PricingModel::find($id);
    }

    public function get(string $id): Pricing
    {
        $model = PricingModel::find($id);
        return $this->factory->make($model);
    }
}
