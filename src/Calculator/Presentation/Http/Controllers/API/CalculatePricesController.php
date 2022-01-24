<?php

namespace Src\Calculator\Presentation\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Src\Calculator\Presentation\Http\Requests\CalculatePriceRequest;
use Src\Calculator\Presentation\Http\Transformers\CalculatePriceTransformer;
use Src\Calculator\Domain\UseCases\Contracts\CalculatePrice;

class CalculatePricesController extends Controller
{
    private CalculatePriceTransformer $transformer;
    private CalculatePrice $calculatePriceUseCase;

    public function __construct(CalculatePriceTransformer $transformer, CalculatePrice $calculatePriceUseCase)
    {
        $this->transformer = $transformer;
        $this->calculatePriceUseCase = $calculatePriceUseCase;
    }

    public function calculate(CalculatePriceRequest $request)
    {
        $data = $this->transformer->transform($request);

        $price = $this->calculatePriceUseCase->calculate($data);

        return response()->json($price);
    }
}
