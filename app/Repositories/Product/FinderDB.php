<?php

namespace App\Repositories\Product;

use App\Exceptions\Store\InvalidStoreException;
use App\Factories\Product\Product as ProductFactory;
use App\Models\Product as ProductModel;
use Barrigudinha\Pricing\Repositories\Contracts\ProductFinder;
use Barrigudinha\Product\Product;
use Barrigudinha\Store\Repositories\StoreRepository;

class FinderDB implements ProductFinder
{
    private StoreRepository $storeRepository;

    public function __construct(StoreRepository $storeRepository)
    {
        $this->storeRepository = $storeRepository;
    }

    /**
     * @return Product[]
     */
    public function all(): array
    {
        $products = array_map(function ($product) {
            return Product::createFromArray($product);
        }, ProductModel::all()->toArray());

        return $products;
    }

    /**
     * @throw InvalidStoreException
     * @return Product[]
     */
    public function allByStore(string $store): array
    {
        if (!in_array($store, $this->storeRepository->all())) {
            throw new InvalidStoreException($store);
        }

        $products = array_filter(ProductModel::all()->all(), function (ProductModel $product) use ($store) {
            return $product->inStore($store);
        });

        return array_map(function (ProductModel $product) {
            return ProductFactory::buildFromModel($product);
        }, $products);
    }

    public function get(string $sku): ?Product
    {
        if ($model = ProductModel::find($sku)) {
            return ProductFactory::buildFromModel($model);
        }

        return null;
    }
}
