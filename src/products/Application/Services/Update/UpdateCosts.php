<?php

namespace Src\Products\Application\Services\Update;

use Src\Prices\Calculator\Domain\Services\CalculateProduct;
use Src\Products\Application\Factories\Costs;
use Src\Products\Domain\Product\Models\Product;
use Src\Prices\Price\Application\Services\Exceptions\ProductNotFound;
use Src\Prices\Price\Application\Services\Products\UpdateDB;

class UpdateCosts
{
    private CalculateProduct $calculateProduct;
    private UpdateDB $updatePriceService;

    public function __construct(CalculateProduct $calculateProduct, UpdateDB $updatePriceService)
    {
        $this->calculateProduct = $calculateProduct;
        $this->updatePriceService = $updatePriceService;
    }

    public function execute(string $sku, array $data): bool
    {
        if (!$product = Product::find($sku)) {
            throw new ProductNotFound();
        }

        $products = $this->getProducts($product);

        foreach ($products as $product) {
            $costs = Costs::make($data, $product->data());
            $product->setCosts($costs);
            $product->save();

            $this->calculateProduct->recalculateProfit($product);
        }

        return true;
    }

    private function getProducts(Product $product): array
    {
        $products[] = $product;

        foreach ($product->data()->getVariations()->get() as $variation) {
            $variationModel = Product::find($variation->getSku());
            $products[] = $variationModel;
        }

        return $products;
    }
}
