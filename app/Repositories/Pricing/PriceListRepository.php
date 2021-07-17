<?php

namespace App\Repositories\Pricing;

use App\Factories\Product\Product as ProductFactory;
use App\Models\Pricing as PricingModel;
use App\Models\Product as ProductModel;
use App\Repositories\Product\FinderDB;
use Barrigudinha\Pricing\PriceList\Contracts\PriceListRepository as PriceListRepositoryInterface;
use Barrigudinha\Pricing\PriceList\PriceList;

class PriceListRepository implements PriceListRepositoryInterface
{
    private FinderDB $productRepository;

    public function __construct(FinderDB $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function get(string $id): PriceList
    {
        $model = PricingModel::find($id);

        $products = array_map(function (ProductModel $product) {
            return ProductFactory::buildFromModel($product);
        }, $model->products->all());

        return new PriceList(
            $id,
            $model->name,
            $products,
            $model->stores
        );

        return $priceList;
    }
}
