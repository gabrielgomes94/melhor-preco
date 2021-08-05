<?php

namespace App\Repositories\Product;

use App\Exceptions\Store\InvalidStoreException;
use App\Factories\Product\Product as ProductFactory;
use App\Models\Product as ProductModel;
use App\Repositories\Product\Options\Options;
use Barrigudinha\Pricing\Repositories\Contracts\ProductFinder;
use Barrigudinha\Product\Entities\Product;
use Barrigudinha\Store\Repositories\StoreRepository;
use PhpOption\Option;

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
        $products = $this->mapProducts($products);

        $products = $this->filterActives($products);

        foreach ($products as $product) {
            $productList[] = $product;
        }

        return $productList;
    }

    /**
     * @throw InvalidStoreException
     * @return Product[]
     */
    public function allByStore(string $store, ?Options $options = null): array
    {
        if (!in_array($store, $this->storeRepository->all())) {
            throw new InvalidStoreException($store);
        }

        $products = $this->filter($this->getProducts(), $store, $options);

        $products = $this->mapProducts($products);

        if ($options->filterKits() === true) {
            $products = $this->filterKits($products);;
        }


        return $products;
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
     * @param ProductModel[]
     * @return Product[]
     */
    private function mapProducts(array $products): array
    {
        return array_map(function (ProductModel $product) {
            return ProductFactory::buildFromModel($product);
        }, $products);
    }

    // To Do: criar método para checar inativos do lado do Produto. Verificar também o campo Ativo que será adicionado no banco
    private function filterActives(array $products): array
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
    private function filterKits(array $products): array
    {
        foreach ($products as $product) {
            if ($product->hasCompositionProducts()) {
                $kits[] = $product;
            }
        };

        return $kits ?? [];
    }

    /**
     * @param ProductModel[] $products
     * @return array|bool
     */
    private function filter(array $products, string $store, Options $options): array
    {
        foreach ($products as $product) {
            if (!$product->inStore($store)) {
                continue;
            }

            if (!$options->hasProfitFilters()) {
                $productsList[] = $product;

                continue;
            }

            if ($this->isInMarginRange($product, $store, $options)) {
                $productsList[] = $product;
            }
        }

        return $productsList ?? [];
    }

    private function isInMarginRange(ProductModel $product, string $store, Options $options)
    {
        return $product
            ->getPrice($store)
            ->isProfitMarginInRange($options->minimumProfit(), $options->maximumProfit());
    }
}
