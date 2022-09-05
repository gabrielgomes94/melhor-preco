<?php

namespace Src\Prices\Infrastructure\Laravel\Http\Controllers\Web\Price;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Src\Marketplaces\Domain\Exceptions\MarketplaceNotFoundException;
use Src\Prices\Infrastructure\Laravel\Http\Requests\MassCalculatePriceRequest;
use Src\Prices\Infrastructure\Laravel\Presenters\PriceList\MassCalculatedPricesPresenter;
use Src\Prices\Infrastructure\Laravel\Services\MassCalculatePrices;

class MassCalculateController extends Controller
{
    public function __construct(
        private MassCalculatePrices $massCalculatePrices,
        private MassCalculatedPricesPresenter $massCalculatedPricesPresenter
    )
    {}

    /**
     * @throws MarketplaceNotFoundException
     */
    public function __invoke(string $marketplaceSlug, MassCalculatePriceRequest $request): Application|Factory|View
    {
        $userId = $this->getUserId();
        $form = $request->transform();

        $prices = $this->massCalculatePrices->calculate($marketplaceSlug, $userId, $form);
        $data = $this->massCalculatedPricesPresenter->present($prices, $userId);

        return view('pages.pricing.prices.list', $data);
    }
}
