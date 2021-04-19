<?php

namespace App\Http\Controllers\API\Pricing;

use App\Http\Controllers\Controller;
use App\Repositories\Pricing\ProductRepository;
use App\Services\Pricing\CalculatePrice;
use Barrigudinha\Pricing\Data\Tax;
use Illuminate\Http\Request;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;

class CalculatePricesController extends Controller
{
    private ProductRepository $repository;
    private CalculatePrice $service;

    public function __construct(ProductRepository $repository, CalculatePrice $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function calculate(string $pricingId, string $productId, string $priceId, Request $request)
    {
        if(!$product = $this->repository->getById($productId)) {
            abort(404);
        }

        $price = $this->service->calculate($product, $request);

        return response()->json(compact('price'));
    }
}

