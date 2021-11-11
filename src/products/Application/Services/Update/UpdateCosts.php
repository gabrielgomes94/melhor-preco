<?php

namespace Src\Products\Application\Services\Update;

use Src\Products\Application\Factories\Costs;
use Src\Products\Domain\Product\Events\ProductCostsUpdated;
use Src\Products\Domain\Product\Models\Product;
use Src\Prices\Price\Application\Services\Exceptions\ProductNotFound;
use Src\Prices\Price\Application\Services\Products\UpdateDB;

class UpdateCosts
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
            $costs = Costs::make($data, $product->data());
            $product->setCosts($costs);
            $product->save();

            event(new ProductCostsUpdated($product));
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
