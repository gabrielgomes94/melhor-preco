<?php

namespace App\Http\Controllers\Front\Pricing;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pricing\Product\UpdateRequest;
use App\Services\Pricing\UpdateProduct as UpdateProductService;
use Illuminate\Http\Request;

class UpdateProductPricingController extends Controller
{
    private UpdateProductService $service;

    public function __construct(UpdateProductService $service)
    {
        $this->service = $service;
    }

    public function update(string $pricingId, string $productId, UpdateRequest $request)
    {
//        dd($request->validated());
//        $data = $this->service->updateProductData($request->all());
//
        $this->service->updateProduct($productId, $request->validated());

        return redirect(route('pricing.products.show', [
            'pricing_id' => $pricingId,
            'product_id' => $productId
        ]));
    }
}
