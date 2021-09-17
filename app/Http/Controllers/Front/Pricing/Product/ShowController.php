<?php

namespace App\Http\Controllers\Front\Pricing\Product;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Utils\Breadcrumb;
use App\Presenters\Pricing\Product\Presenter;
use App\Repositories\Product\GetDB;
use Barrigudinha\Pricing\PostPriced\Services\CreatePostPriced;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;

class ShowController extends Controller
{
    private GetDB $repository;
    private Presenter $presenter;
    private CreatePostPriced $createPostPriced;
    private Breadcrumb $breadcrumb;

    public function __construct(
        GetDB $repository,
        Presenter $presenter,
        CreatePostPriced $createPostPriced,
        Breadcrumb $breadcrumb
    ) {
        $this->repository = $repository;
        $this->presenter = $presenter;
        $this->createPostPriced = $createPostPriced;
        $this->breadcrumb = $breadcrumb;
    }

    /**
     * @return Application|ViewFactory|View
     */
    public function showByStore(string $store, string $productId)
    {
        $product = $this->repository->get($productId);

        if (!$product) {
            abort(404);
        }

        $price = $this->createPostPriced->create($product, $product->getStore($store));
        $productInfo = $this->presenter->singleProduct($product);
        $prices = $this->presenter->prices([$price]);
        $store = $product->getStore($store);

        $breadcrumb = $this->breadcrumb->generate(
            Breadcrumb::priceListIndex(),
            Breadcrumb::priceListByStore($store->name(), $store->slug()),
            Breadcrumb::product($productInfo->name()),
        );

        return view('pages.pricing.products.show', [
            'breadcrumb' => $breadcrumb,
            'productInfo' => $productInfo,
            'prices' => $prices,
            'store' => $store,
        ]);
    }
}
