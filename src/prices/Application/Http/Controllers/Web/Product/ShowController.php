<?php

namespace Src\Prices\Application\Http\Controllers\Web\Product;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Utils\Breadcrumb;
use App\Repositories\Product\GetDB;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;
use Src\Prices\Domain\PostPriced\Services\CreatePostPriced;

class ShowController extends Controller
{
    private GetDB $repository;
    private CreatePostPriced $createPostPriced;
    private Breadcrumb $breadcrumb;

    public function __construct(
        GetDB $repository,
        CreatePostPriced $createPostPriced,
        Breadcrumb $breadcrumb
    ) {
        $this->repository = $repository;
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
        $store = $product->getStore($store);

        $breadcrumb = $this->breadcrumb->generate(
            Breadcrumb::priceListIndex(),
            Breadcrumb::priceListByStore($store->name(), $store->slug()),
            Breadcrumb::product($product->name()),
        );

        return view('pages.pricing.products.show', [
            'breadcrumb' => $breadcrumb,
            'store' => $store,
            'price' => $price,
        ]);
    }
}
