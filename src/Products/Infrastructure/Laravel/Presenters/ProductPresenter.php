<?php

namespace Src\Products\Infrastructure\Laravel\Presenters;

use Src\Math\Transformers\NumberTransformer;
use Src\Products\Domain\Models\Product;

class ProductPresenter
{
    public function present(Product $product): array
    {
        return [
            'sku' => $product->getSku(),
            'category' => $product->getCategory()?->getName() ?? '',
            'dimensions' => $this->getDimensions($product),
            'images' => $product->getImages(),
            'name' => $product->getName(),
            'quantity' => $product->getQuantity(),
            'weight' => $this->getWeight($product),
        ];
    }

    private function getDimensions(Product $product): string
    {
        $depth = $product->getDimensions()->depth();
        $height = $product->getDimensions()->height();
        $width = $product->getDimensions()->width();

        return $depth . ' x ' . $height . ' x ' . $width . ' cm';
    }

    private function getWeight(Product $product): string
    {
        $weight = $product->getDimensions()->weight();

        return NumberTransformer::toText($weight, 3) . ' kg';
    }
}
