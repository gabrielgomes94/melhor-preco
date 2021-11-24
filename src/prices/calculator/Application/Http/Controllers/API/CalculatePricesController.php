<?php

namespace Src\Prices\Calculator\Application\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Src\Prices\Calculator\Application\Http\Requests\CalculatePriceRequest;
use Src\Prices\Calculator\Application\Http\Transformers\CalculatePriceTransformer;
use Src\Prices\Calculator\Application\UseCases\CalculatePrice;

class CalculatePricesController extends Controller
{
    private CalculatePriceTransformer $transformer;
    private CalculatePrice $calculatePrice;

    public function __construct(CalculatePriceTransformer $transformer, CalculatePrice $calculatePrice)
    {
        $this->transformer = $transformer;
        $this->calculatePrice = $calculatePrice;
    }

    public function calculate(CalculatePriceRequest $request)
    {
        $data = $this->transformer->transform($request);

        $price = $this->calculatePrice->calculate($data);

        return response()->json($price);
    }
}
