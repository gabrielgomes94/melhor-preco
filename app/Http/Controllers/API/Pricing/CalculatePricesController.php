<?php

namespace App\Http\Controllers\API\Pricing;

use App\Http\Controllers\Controller;
use App\Repositories\Pricing\Product\FinderDB as ProductRepository;
use Barrigudinha\Pricing\Services\PriceCalculator\Calculate;
use Illuminate\Http\Request;

class CalculatePricesController extends Controller
{
    private ProductRepository $repository;
    private Calculate $service;

    public function __construct(ProductRepository $repository, Calculate $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function calculate(string $pricingId, string $productId, string $priceId, Request $request)
    {
        if(!$product = $this->repository->getById($productId)) {
            abort(404);
        }

        $price = $this->service->calculate($product, $request->all());

        return response()->json(compact('price'));
    }
}

