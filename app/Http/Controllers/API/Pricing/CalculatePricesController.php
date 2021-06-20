<?php

namespace App\Http\Controllers\API\Pricing;

use App\Http\Controllers\Controller;
use App\Http\Transformers\Pricing\PriceTransformer;
use App\Repositories\Product\FinderDB as ProductRepository;
use Barrigudinha\Pricing\Data\PostPriced\MagaluPostPriced;
use Barrigudinha\Pricing\Data\PostPriced\PostPriced;
use Barrigudinha\Pricing\Services\PriceCalculator\Calculate;
use Illuminate\Http\Request;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;

class CalculatePricesController extends Controller
{
    private ProductRepository $repository;
    private Calculate $service;
    private PriceTransformer $transformer;

    public function __construct(ProductRepository $repository, Calculate $service, PriceTransformer $transformer)
    {
        $this->repository = $repository;
        $this->service = $service;
        $this->transformer = $transformer;
    }

    public function calculate(string $pricingId, string $productId, string $priceId, Request $request)
    {
        if (!$product = $this->repository->get($productId)) {
            abort(404);
        }

        $postPriced = $this->service->calculate(
            $product,
            $request->input('store'),
            $request->input('desiredPrice'),
            $request->input('commission'),
            $request->input('additionalCosts', 0.0),
        );

        $price = $this->transformer->transform($postPriced);

        return response()->json($price);
    }
}
