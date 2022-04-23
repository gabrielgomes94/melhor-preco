<?php

namespace Src\Calculator\Presentation\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Src\Calculator\Presentation\Http\Requests\CalculatePriceRequest;
use Src\Calculator\Presentation\Http\Transformers\CalculatePriceTransformer;
use Src\Calculator\Domain\UseCases\Contracts\CalculatePrice;
use Src\Calculator\Presentation\Presenters\PricePresenter;

class CalculatePricesController extends Controller
{
    public function __construct(
//        private CalculatePriceTransformer $transformer,
        private CalculatePrice $calculatePriceUseCase,
        private PricePresenter $presenter
    ) {}

    public function calculate(CalculatePriceRequest $request): JsonResponse
    {
//        $data = $this->transformer->transform($request);
        $data = $request->transform();

        dd($data);
        $price = $this->calculatePriceUseCase->calculate($data);
        $price = $this->presenter->transform($price);

        return response()->json($price);
    }
}
