<?php

namespace App\Http\Controllers\Front\Pricing;

use App\Http\Controllers\Controller;
use App\Repositories\Pricing\Product\Remover;
use Illuminate\Http\Request;

class RemoveProductController extends Controller
{
    private Remover $repository;

    public function __construct(Remover $repository)
    {
        $this->repository = $repository;
    }

    public function remove(string $pricingId, string $productId, Request $request)
    {
        $this->repository->dissociate($pricingId, $productId);

        return redirect()->route('pricing.show', [$pricingId]);
    }
}
