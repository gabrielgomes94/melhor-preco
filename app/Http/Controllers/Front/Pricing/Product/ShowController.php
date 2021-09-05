<?php

namespace App\Http\Controllers\Front\Pricing\Product;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Utils\Breadcrumb;
use App\Models\Pricing;
use App\Presenters\Pricing\Product\Presenter;
use App\Repositories\Pricing\PriceListRepository;
use App\Repositories\Product\GetDB;
use Barrigudinha\Pricing\PostPriced\Services\CreatePostPriced;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;

class ShowController extends Controller
{
    private PriceListRepository $priceListRepository;
    private GetDB $repository;
    private Presenter $presenter;
    private CreatePostPriced $createPostPriced;
    private Breadcrumb $breadcrumb;

    public function __construct(
        PriceListRepository $priceListRepository,
        GetDB $repository,
        Presenter $presenter,
        CreatePostPriced $createPostPriced,
        Breadcrumb $breadcrumb
    ) {
        $this->priceListRepository = $priceListRepository;
        $this->repository = $repository;
        $this->presenter = $presenter;
        $this->createPostPriced = $createPostPriced;
        $this->breadcrumb = $breadcrumb;
    }

    /**
     * @return Application|ViewFactory|View
     */
    public function show(string $priceListId, string $productId)
    {
        $product = $this->repository->get($productId);

        if (!$product) {
            abort(404);
        }

        $pricing = Pricing::find($priceListId);
        $priceList = $this->priceListRepository->get($priceListId);

        $productInfo = $this->presenter->singleProduct($product);

        $stores = $product->getStores($pricing->stores);
        $prices = $this->createPostPriced->createList($product, $stores);
        $prices = $this->presenter->prices($prices);

        $breadcrumb = $this->breadcrumb->generate(
            Breadcrumb::priceListIndex(),
            Breadcrumb::priceListCustom($priceList),
            Breadcrumb::product($productInfo->name()),
        );

        return view('pages.pricing.products.show', [
            'breadcrumb' => $breadcrumb,
            'productInfo' => $productInfo,
            'pricingId' => $priceListId,
            'prices' => $prices
        ]);
    }

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
            'prices' => $prices
        ]);
    }
}
