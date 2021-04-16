<?php

namespace App\Http\Controllers\Front\Pricing;

use App\Http\Controllers\Controller;
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

        $productInfo = $this->presenter->single($product);

        return view('pricing.products.show', [
            'productInfo' => $productInfo,
        ]);
    }
}
