<?php

namespace Src\Prices\PriceList\Application\Http\Controllers\Web\Product;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Utils\Breadcrumb;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;
use Src\Products\Infrastructure\Repositories\V2\Repository;

class ShowController extends Controller
{
    private Repository $repository;
    private Breadcrumb $breadcrumb;

    public function __construct(
        Repository $repository,
        Breadcrumb $breadcrumb
    ) {
        $this->repository = $repository;
        $this->breadcrumb = $breadcrumb;
    }

    /**
     * @return Application|ViewFactory|View
     */
    public function showByStore(string $storeSlug, string $productId)
    {
        $product = $this->repository->get($productId);

        if (!$product) {
            abort(404);
        }

        $post = $product->data()->getPost($storeSlug);
        $store = $product->data()->getStore($storeSlug);

        $breadcrumb = $this->breadcrumb->generate(
            Breadcrumb::priceListIndex(),
            Breadcrumb::priceListByStore($store->getName(), $store->getSlug()),
            Breadcrumb::product($product->data()->getDetails()->getName()),
        );

        return view('pages.pricing.products.show', [
            'breadcrumb' => $breadcrumb,
            'store' => $store,
            'post' => $post,
            'product' => $product->data(),
        ]);
    }
}
