<?php

namespace Src\Prices\Presentation\Http\Controllers\Web\Price;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Utils\Breadcrumb;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;
use Src\Prices\Domain\UseCases\Contracts\ShowPrice;
use Src\Prices\Presentation\Presenters\PricePresenter;
use Src\Prices\Presentation\Presenters\ProductPresenter;
use Src\Products\Application\Exceptions\PostNotFoundException;
use Src\Products\Application\Exceptions\ProductNotFoundException;
use Src\Products\Domain\Models\Product\Product;

class ShowController extends Controller
{
    private ProductPresenter $productPresenter;
    private ShowPrice $showPrice;

    public function __construct(
        ProductPresenter $productPresenter,
        ShowPrice $showPrice
    ) {
        $this->productPresenter = $productPresenter;
        $this->showPrice = $showPrice;
    }

    /**
     * @return Application|ViewFactory|View
     */
    public function showByStore(string $storeSlug, string $productId)
    {
        try {
            $data = $this->showPrice->show($productId, $storeSlug);
        } catch (ProductNotFoundException $exception) {
            abort(404);
        } catch (PostNotFoundException $exception) {
            return view('pages.pricing.products.not-integrated');
        } finally {
            return view('pages.pricing.products.show', $this->productPresenter->present($data));
        }
    }
}
