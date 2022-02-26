<?php

namespace Src\Products\Presentation\Presenters\Reports;

use Src\Products\Domain\Models\Product\Contracts\Product;

class ProductPresenter
{
    public function present(Product $product): array
    {
        $data = $product->toArray();
        $dimensions = $this->getDimensions($product);
        $weight = $product->getDimensions()->weight() . ' kg';

        return array_merge(
            $data,
            [
                'category' => $product->getCategory()?->getName() ?? '',
                'dimensions' => $dimensions,
                'weight' => $weight
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
}
