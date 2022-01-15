<?php

namespace Src\Prices\Application\Http\Controllers\Web\Price;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Utils\Breadcrumb;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;
use Src\Products\Domain\Models\Product\Product;

class ShowController extends Controller
{
    private Breadcrumb $breadcrumb;

    public function __construct(
        Breadcrumb $breadcrumb
    ) {
        $this->breadcrumb = $breadcrumb;
    }

    /**
     * @return Application|ViewFactory|View
     */
    public function showByStore(string $storeSlug, string $productId)
    {
        if (!$product = Product::find($productId)) {
            abort(404);
        }

        if (!$post = $product->getPost($storeSlug)) {
            return view('pages.pricing.products.not-integrated');
        }

        $store = $product->getStore($storeSlug);
        $breadcrumb = $this->breadcrumb->generate(
            Breadcrumb::priceListIndex(),
            Breadcrumb::priceListByStore($store->getName(), $store->getSlug()),
            Breadcrumb::product($product->getDetails()->getName()),
        );

        return view('pages.pricing.products.show', [
            'breadcrumb' => $breadcrumb,
            'store' => $store,
            'post' => $post,
            'product' => $product,
        ]);
    }
}
