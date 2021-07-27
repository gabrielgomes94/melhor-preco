<?php

namespace App\Repositories\Product;

use App\Exceptions\Store\InvalidStoreException;
use App\Factories\Product\Product as ProductFactory;
use App\Models\Product as ProductModel;
use Barrigudinha\Pricing\Repositories\Contracts\ProductFinder;
use Barrigudinha\Product\Product;
use Barrigudinha\Store\Repositories\StoreRepository;
use Barrigudinha\Utils\Helpers;

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
        $products = $this->getProducts();

        return $this->mapProducts($products);
    }

    /**
     * @throw InvalidStoreException
     * @return Product[]
     */
    public function allByStore(string $store, array $options = []): array
    {
        if (!in_array($store, $this->storeRepository->all())) {
            throw new InvalidStoreException($store);
        }

        $products = array_filter(
            $this->getProducts(),
            function (ProductModel $product) use ($store, $options) {
                if (!$product->inStore($store)) {
                    return false;
                }

                if (empty($options)) {
                    return true;
                }

                return $product->getPrice($store)->isProfitMarginInRange(
                        $options['minimumProfit'] ?? null,
                        $options['maximumProfit'] ?? null
                    );
            }
        );

        return $this->mapProducts($products);
    }

    public function get(string $sku): ?Product
    {
        if ($model = ProductModel::find($sku)) {
            return ProductFactory::buildFromModel($model);
        }

        return null;
    }

    public function getModel(string $sku): ?ProductModel
    {
        return ProductModel::find($sku);
    }

    /**
     * @return ProductModel[]
     */
    private function getProducts(): array
    {
        return ProductModel::whereNull('parent_sku')->get()->sortBy('id')->all();
    }

    /**
     * @return Product[]
     */
    private function mapProducts(array $products): array
    {
        return array_map(function (ProductModel $product) {
            return ProductFactory::buildFromModel($product);
        }, $products);
    }
}
