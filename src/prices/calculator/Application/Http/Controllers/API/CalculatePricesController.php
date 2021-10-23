<?php

namespace Src\Prices\Calculator\Application\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Src\Prices\Calculator\Application\Http\Requests\SimulatePriceRequest;
use Src\Prices\Calculator\Application\Http\Transformer\PriceTransformer;
use Src\Prices\Calculator\Domain\Contracts\Services\SimulatePost;

class CalculatePricesController extends Controller
{
    private SimulatePost $service;
    private PriceTransformer $transformer;

    public function __construct(SimulatePost $service, PriceTransformer $transformer)
    {
        $this->service = $service;
        $this->transformer = $transformer;
    }

    public function calculate(string $productId, string $priceId, SimulatePriceRequest $request)
    {
        $post = $this->service->calculate(
            $productId,
            $request->input('store'),
            (float) $request->input('desiredPrice'),
            (float) $request->input('commission'),
            []
        );

        $price = $this->transformer->transform($post);

        return response()->json($price);
    }
}
