<?php

namespace App\Http\Controllers\Front\Pricing\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pricing\Product\UpdateRequest;
use App\Services\Pricing\UpdateProduct as UpdateProductService;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    private UpdateProductService $service;

    public function __construct(UpdateProductService $service)
    {
        $this->service = $service;
    }

    public function update(string $productId, UpdateRequest $request)
    {
        $this->service->updateProduct($productId, $request->validated());

        return redirect(route('pricing.products.show', [
            'product_id' => $productId
        ]));
    }
}
