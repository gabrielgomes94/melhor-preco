<?php

namespace App\Http\Controllers\Front\Pricing;

use App\Http\Controllers\Controller;
use App\Repositories\Pricing\UpdatePriceRepository;
use Illuminate\Http\Request;

class UpdatePriceController extends Controller
{
    private UpdatePriceRepository $repository;

    public function __construct(UpdatePriceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function update(string $pricingId, string $productId, string $priceId, Request $request)
    {
        $this->repository->update($priceId, $request->all());

        return redirect(route('pricing.products.show', [
            'pricing_id' => $pricingId,
            'product_id' => $productId
        ]));
    }
}
