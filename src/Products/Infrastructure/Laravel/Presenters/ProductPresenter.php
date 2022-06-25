<?php

namespace Src\Products\Infrastructure\Laravel\Presenters;

use Src\Math\MathPresenter;
use Src\Products\Domain\Models\Product\Contracts\Product;

class ProductPresenter
{
    public function present(Product $product): array
    {
        $data = $product->toArray();

        return array_merge(
            $data,
            [
                'category' => $product->getCategory()?->getName() ?? '',
                'dimensions' => $this->getDimensions($product),
                'weight' => $this->getWeight($product)
            ]
        );
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

        return MathPresenter::float($weight, 3) . ' kg';
    }
}
