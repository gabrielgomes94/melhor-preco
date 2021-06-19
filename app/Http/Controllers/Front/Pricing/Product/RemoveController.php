<?php

namespace App\Http\Controllers\Front\Pricing\Product;

use App\Http\Controllers\Controller;
use App\Repositories\Pricing\Product\Remover;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class RemoveController extends Controller
{
    private Remover $repository;

    public function __construct(Remover $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return Redirector|RedirectResponse
     */
    public function remove(string $pricingId, string $productId, Request $request)
    {
        $this->repository->dissociate($pricingId, $productId);

        return redirect()->route('pages.pricing.show', [$pricingId]);
    }
}
