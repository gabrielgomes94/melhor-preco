<?php

namespace App\Repositories\Pricing;

use App\Factories\Product\Product as ProductFactory;
use App\Models\Product as ProductModel;
use App\Repositories\Product\GetDB;
use Barrigudinha\Pricing\PriceList\Contracts\PriceListRepository as PriceListRepositoryInterface;
use Barrigudinha\Pricing\PriceList\PriceList;

class PriceListRepository implements PriceListRepositoryInterface
{
    private GetDB $productRepository;

    public function __construct(GetDB $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function get(string $id): PriceList
    {
        $model = $this->productRepository->getModel($id);

        $products = array_map(function (ProductModel $product) {
            return ProductFactory::buildFromModel($product);
        }, $model->products->all());

        return new PriceList(
            $id,
            $model->name,
            $products,
            $model->stores
        );
    }
}
