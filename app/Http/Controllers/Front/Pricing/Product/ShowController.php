<?php

namespace App\Http\Controllers\Front\Pricing\Product;

use App\Http\Controllers\Controller;
use App\Models\Pricing;
use App\Presenters\Pricing\Product\Presenter;
use App\Repositories\Product\FinderDB as ProductRepository;
use Barrigudinha\Pricing\Services\PriceCalculator\Calculate;
use Barrigudinha\Pricing\Services\PriceCalculator\ProductCalculator;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;

class ShowController extends Controller
{
    private ProductRepository $repository;
    private Presenter $presenter;
    private ProductCalculator $calculator;
    private Calculate $calculateService;

    public function __construct(ProductRepository $repository, Presenter $presenter, ProductCalculator $calculator, Calculate $calculateService)
    {
        $this->repository = $repository;
        $this->presenter = $presenter;
        $this->calculator = $calculator;
        $this->calculateService = $calculateService;
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
        $prices = $this->calculator->execute($product, $pricing->stores);
        $prices = $this->presenter->prices($prices);

        $breadcrumb = [
            'pricing' => [
                'name' => $pricing->name,
                'link' => route('pricing.show', [$priceListId])
            ],
            'product' => [
                'name' => $product->name(),
                'link' => '',
            ],
        ];

        return view('pages.pricing.products.show', [
            'breadcrumb' => $breadcrumb,
            'productInfo' => $productInfo,
            'pricingId' => $pricingId,
            'prices' => $prices
        ]);
    }

    public function showByStore(string $store, string $productId)
    {
        $product = $this->repository->get($productId);

        if (!$product) {
            abort(404);
        }

        $price = $this->calculator->single($product, $store);

        $productInfo = $this->presenter->singleProduct($product);
        $prices = $this->presenter->prices([$price]);

        return view('pages.pricing.products.show', [
            'productInfo' => $productInfo,
            'prices' => $prices
        ]);
    }
}
