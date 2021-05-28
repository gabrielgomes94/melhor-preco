<?php

namespace App\Http\Controllers\Front\Pricing;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pricing\Price\UpdatePrice;
use App\Repositories\Pricing\Price\Updator;

class UpdatePriceController extends Controller
{
    private Updator $repository;

    public function __construct(Updator $repository)
    {
        $this->repository = $repository;
    }

    public function update(string $pricingId, string $productId, string $priceId, UpdatePrice $request)
    {
        $this->repository->update($priceId, $request->validated());

        return redirect()->route('pricing.products.show', [
            'pricing_id' => $pricingId,
            'product_id' => $productId,
        ]);
    }
}
