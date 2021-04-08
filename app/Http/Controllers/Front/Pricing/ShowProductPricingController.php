<?php

namespace App\Http\Controllers\Front\Pricing;

class ShowProductPricingController
{
    public function show($pricingId, $productId)
    {
        return view('pricing.products.show');
    }
}
