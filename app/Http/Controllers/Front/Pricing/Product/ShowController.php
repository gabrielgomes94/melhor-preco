<?php

namespace App\Http\Controllers\Front\Pricing\Product;

use App\Http\Controllers\Controller;
use App\Models\Pricing;
use App\Presenters\Pricing\Product\Presenter;
use App\Repositories\Product\FinderDB as ProductRepository;
use Barrigudinha\Pricing\PostPriced\Services\CreatePostPriced;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;

class ShowController extends Controller
{
    private ProductRepository $repository;
    private Presenter $presenter;
    private CreatePostPriced $createPostPriced;

    public function __construct(ProductRepository $repository, Presenter $presenter, CreatePostPriced $createPostPriced)
    {
        $this->repository = $repository;
        $this->presenter = $presenter;
        $this->createPostPriced = $createPostPriced;
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

        $productInfo = $this->presenter->singleProduct($product);

        $stores = $product->getStores($pricing->stores);
        $prices = $this->createPostPriced->createList($product, $stores);
        $prices = $this->presenter->prices($prices);

        $breadcrumb = [
            [
                'name' => $pricing->name,
                'link' => route('pricing.priceList.custom.show', [$priceListId])
            ],
            [
                'name' => $product->name(),
                'link' => '',
            ],
        ];

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

        $breadcrumb = [
            [
                'link' => route('pricing.priceList.index'),
                'name' => 'Listas de Preços',
            ],
            [
                'link' => route('pricing.priceList.byStore', $store),
                'name' => $store,
            ],
            [
                'link' => '',
                'name' => $productInfo->name(),
            ],
        ];

        return view('pages.pricing.products.show', [
            'breadcrumb' => $breadcrumb,
            'productInfo' => $productInfo,
            'prices' => $prices
        ]);
    }
}
