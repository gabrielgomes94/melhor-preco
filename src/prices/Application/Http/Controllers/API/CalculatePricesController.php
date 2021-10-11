<?php

namespace Src\Prices\Application\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Src\Products\Infrastructure\Repositories\GetDB;
use Barrigudinha\Utils\Helpers;
use Illuminate\Http\Request;
use Src\Prices\Application\Http\Transformer\PriceTransformer;
use Src\Prices\Domain\PostPriced\Services\CreatePostPriced;

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
