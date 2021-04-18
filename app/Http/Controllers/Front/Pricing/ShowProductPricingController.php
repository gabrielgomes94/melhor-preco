<?php

namespace App\Http\Controllers\Front\Pricing;

use App\Http\Controllers\Controller;
use App\Models\Pricing;
use App\Presenters\Pricing\Product\Presenter;
use App\Repositories\Pricing\ProductRepository;

class ShowProductPricingController extends Controller
{
    private ProductRepository $repository;
    private Presenter $presenter;

    public function __construct(ProductRepository $repository, Presenter $presenter)
    {
        $this->repository = $repository;
        $this->presenter = $presenter;
    }

    public function show($pricingId, $productId)
    {
        $product = $this->repository->getById($productId);

        if (!$product) {
            abort(404);
        }

        $productInfo = $this->presenter->singleProduct($product);
        $prices = $this->presenter->prices($product);

        $breadcrumb = [
            'pricing' => [
                'name' => Pricing::find($pricingId)->name,
                'link' => route('pricing.show', [$pricingId])
            ],
            'product' => [
                'name' => $product->name(),
                'link' => '',
            ],
        ];

        return view('pricing.products.show', [
            'breadcrumb' => $breadcrumb,
            'productInfo' => $productInfo,
            'pricingId' => $pricingId,
            'prices' => $prices
        ]);
    }
}
