<?php

namespace Src\Products\Infrastructure\Laravel\Presenters;

use Src\Math\MathPresenter;
use Src\Products\Domain\Models\Product;

class ProductPresenter
{
    public function present(Product $product): array
    {
        return [
            'id' => '2',
            'sku' => $product->getSku(),
            'name' => $product->getName(),
            'purchase_price' => $product->getCosts()->purchasePrice(),
            'tax_icms' => $product->getCosts()->taxICMS(),
            'additional_costs' => $product->getCosts()->additionalCosts(),
            'depth' => $product->getDimensions()->depth(),
            'width' => $product->getDimensions()->width(),
            'height' => $product->getDimensions()->height(),
            'weight' => $this->getWeight($product),
            'erp_id' => $product->getErpId(),
            'parent_sku' => $product->getParentSku(),
            'has_variations' => $product->hasVariations(),
            'composition_products' => $product->getComposition()->getSkus(),
            'ean' => $product->getEan(),
            'is_active' => $product->isActive(),
            'brand' => 'Galzerano',
            'images' => $product->getImages(),
            'category_id' => $product->getCategory()?->getCategoryId(),
            'quantity' => $product->getQuantity(),
            'user_id' => 2,
            'category' => $product->getCategory()?->getName() ?? '',
            'dimensions' => $this->getDimensions($product),
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

        return MathPresenter::float($weight, 3) . ' kg';
    }
}
