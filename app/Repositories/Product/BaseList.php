<?php

namespace App\Repositories\Product;

use App\Models\Product as ProductModel;
use App\Repositories\Product\Options\Options;
use Barrigudinha\Product\Entities\Product;
use Barrigudinha\Store\Repositories\StoreRepository;

abstract class BaseList
{
    protected StoreRepository $storeRepository;

    public function __construct(StoreRepository $storeRepository)
    {
        $this->storeRepository = $storeRepository;
    }

    public function all(?Options $options = null): array
    {
        if (!$options) {
            $options = new Options([]);
        }

        $totalProducts = $this->getProducts($options);
        $products = $this->mapProducts($totalProducts, $options);
        $products = $this->filterActives($products);

        if ($options->filterKits() === true) {
            $products = $this->filterKits($products);
        }

        foreach ($products as $product) {
            $productList[] = $product;
        }


        return [
            'items' => $productList ?? [],
            'total' => $this->countProducts($options),
        ];
    }

    protected abstract function countProducts(Options $options): int;
    protected abstract function getProducts(Options $options): array;
    protected abstract function mapProducts(array $products, Options $options): array;

    protected function filterActives(array $products): array
    {
        foreach ($products as $product) {
            if (empty($product->posts())) {
                continue;
            }

            $activeProducts[] = $product;
        }

        return $activeProducts ?? [];
    }

    /**
     * @param Product[] $products
     */
    protected function filterKits(array $products): array
    {
        foreach ($products as $product) {
            if ($product->hasCompositionProducts()) {
                $kits[] = $product;
            }
        };

        return $kits ?? [];
    }

    protected function isInMarginRange(ProductModel $product, string $store, Options $options): bool
    {
        return $product
            ->getPrice($store)
            ->isProfitMarginInRange($options->minimumProfit(), $options->maximumProfit());
    }
}
