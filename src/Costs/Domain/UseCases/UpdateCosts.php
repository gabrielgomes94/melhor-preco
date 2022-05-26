<?php

namespace Src\Costs\Domain\UseCases;

use Src\Products\Domain\Events\Product\ProductCostsUpdated;
use Src\Products\Domain\Models\Product\Data\Costs\Costs;
use Src\Products\Domain\Models\Product\Product;
use Src\Prices\Application\Services\Exceptions\ProductNotFound;
use Src\Prices\Application\Services\Products\UpdateDB;
use Src\Costs\Domain\UseCases\Contracts\UpdateCosts as UpdateCostsInterface;

class UpdateCosts implements UpdateCostsInterface
{
    private UpdateDB $updatePriceService;

    public function __construct(UpdateDB $updatePriceService)
    {
        $this->updatePriceService = $updatePriceService;
    }

    public function execute(string $sku, array $data): bool
    {
        if (!$product = Product::find($sku)) {
            throw new ProductNotFound();
        }

        $products = $this->getProducts($product);

        foreach ($products as $product) {
            $costs = Costs::make($data, $product);
            $product->setCosts($costs);
            $product->save();

            event(new ProductCostsUpdated($product));
        }

        return true;
    }

    private function getProducts(Product $product): array
    {
        $products[] = $product;

        foreach ($product->getVariations()->get() as $variation) {
            $variationModel = Product::find($variation->getSku());
            $products[] = $variationModel;
        }

        return $products;
    }
}
