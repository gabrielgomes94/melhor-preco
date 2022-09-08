<?php

namespace Src\Prices\Infrastructure\Laravel\Http\Controllers\Web\Price;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Src\Marketplaces\Domain\Exceptions\MarketplaceNotFoundException;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Prices\Infrastructure\Laravel\Http\Requests\MassCalculatePriceRequest;
use Src\Prices\Infrastructure\Laravel\Presenters\PriceList\MassCalculatedPricesPresenter;
use Src\Prices\Infrastructure\Laravel\Services\MassCalculatePrices;

class MassCalculateController extends Controller
{
    public function __construct(
        private readonly MarketplaceRepository $marketplaceRepository,
        private readonly MassCalculatePrices $massCalculatePrices,
        private readonly MassCalculatedPricesPresenter $massCalculatedPricesPresenter
    )
    {}

    /**
     * @throws MarketplaceNotFoundException
     */
    public function __invoke(string $marketplaceSlug, MassCalculatePriceRequest $request): Application|Factory|View
    {
        $form = $request->transform();
        $marketplace = $this->getMarketplace($marketplaceSlug);
        $prices = $this->massCalculatePrices->calculate($marketplace, $form);
        $data = $this->massCalculatedPricesPresenter->present($prices, $this->getUserId());

        return view('pages.pricing.prices.list', $data);
    }

    /**
     * @throws MarketplaceNotFoundException
     */
    private function getMarketplace(string $marketplaceSlug): Marketplace
    {
        return $this->marketplaceRepository->getBySlug($marketplaceSlug, $this->getUserId())
            ?? throw new MarketplaceNotFoundException($marketplaceSlug);
    }
}
