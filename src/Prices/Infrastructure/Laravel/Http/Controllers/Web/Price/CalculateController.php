<?php

namespace Src\Prices\Infrastructure\Laravel\Http\Controllers\Web\Price;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;
use Src\Marketplaces\Domain\Exceptions\MarketplaceNotFoundException;
use Src\Prices\Domain\Exceptions\ProductHasNoPriceInMarketplace;
use Src\Prices\Infrastructure\Laravel\Http\Requests\CalculatePriceRequest;
use Src\Prices\Infrastructure\Laravel\Presenters\Calculator\CalculatorPresenter;
use Src\Prices\Infrastructure\Laravel\Services\Prices\CalculatePriceFromProduct;
use Src\Products\Domain\Exceptions\ProductNotFoundException;

class CalculateController extends Controller
{
    public function __construct(
        private CalculatorPresenter $productPresenter,
        private CalculatePriceFromProduct $calculatePriceFromProduct
    ) {
    }

    /**
     * @return Application|ViewFactory|View
     * @throws ProductNotFoundException
     * @throws ProductHasNoPriceInMarketplace
     * @throws MarketplaceNotFoundException
     */
    public function __invoke(string $storeSlug, string $productId, CalculatePriceRequest $request)
    {
        $userId = $this->getUserId();
        $calculatorForm = $request->transform();

        $priceCalculatedFromProduct = $this->calculatePriceFromProduct->calculate(
            $productId,
            $storeSlug,
            $userId,
            $calculatorForm
        );

        $presented = $this->productPresenter->present(
            $priceCalculatedFromProduct,
            $request
        );

        return view(
            'pages.pricing.products.show',
            $presented
        );
    }
}
