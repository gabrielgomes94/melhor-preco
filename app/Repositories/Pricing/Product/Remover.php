<?php

namespace App\Repositories\Pricing\Product;

use App\Models\Pricing;
use App\Models\Product;

class Remover
{
    public function dissociate(string $pricingId, string $productId)
    {
        if (!$product = Product::find($productId)) {
            return false;
        }

        if (!$pricing = Pricing::find($pricingId)) {
            return false;
        }

        return $pricing->products()->detach($product);
    }
}
