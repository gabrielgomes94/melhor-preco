<?php

namespace Src\Prices\Application\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Transformers\Pricing\PriceTransformer;
use App\Repositories\Product\GetDB;
use Barrigudinha\Pricing\PostPriced\Services\CreatePostPriced;
use Barrigudinha\Utils\Helpers;
use Illuminate\Http\Request;

class CalculatePricesController extends Controller
{
    private GetDB $repository;
    private PriceTransformer $transformer;
    private CreatePostPriced $createPostPriced;

    public function __construct(GetDB $repository, PriceTransformer $transformer, CreatePostPriced $createPostPriced)
    {
        $this->repository = $repository;
        $this->transformer = $transformer;
        $this->createPostPriced = $createPostPriced;
    }

    public function calculate(string $productId, string $priceId, Request $request)
    {
        if (!$product = $this->repository->get($productId)) {
            abort(404);
        }

        if (!$store = $product->getStore($request->input('store'))) {
            // To Do: show errors
        }
        $desiredPrice = Helpers::floatToMoney($request->input('desiredPrice'));

        $postPriced = $this->createPostPriced->create($product, $store, $desiredPrice, [
            'commission' => $request->input('commission'),
            'discount' => $request->input('discount'),
        ]);

        $price = $this->transformer->transform($postPriced);

        return response()->json($price);
    }
}
