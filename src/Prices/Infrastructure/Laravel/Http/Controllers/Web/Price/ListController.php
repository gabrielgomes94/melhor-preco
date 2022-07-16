<?php

namespace Src\Prices\Infrastructure\Laravel\Http\Controllers\Web\Price;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Src\Marketplaces\Domain\Exceptions\MarketplaceNotFoundException;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Prices\Infrastructure\Laravel\Http\Requests\PriceList\ShowRequest;
use Src\Prices\Infrastructure\Laravel\Models\Price;
use Src\Prices\Infrastructure\Laravel\Presenters\PriceListPresenter;
use Src\Prices\Infrastructure\Laravel\Services\Products\ListProducts;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;
use Src\Products\Infrastructure\Laravel\Repositories\Options\Options;

class ListController extends Controller
{
    public function __construct(
        private readonly ListProducts $listProductsService,
        private readonly PriceListPresenter $priceListPresenter,
        private readonly MarketplaceRepository $marketplaceRepository
    ) {
    }

    public function __invoke(ShowRequest $request, ?string $marketplaceSlug = null): Application|Factory|View
    {
        $userId = auth()->user()->getAuthIdentifier();

        if (!$marketplaceSlug) {
            $marketplaceSlug = $this->marketplaceRepository->first($userId)->getSlug();
        }

        $products = $this->listProductsService->listPaginate(
            $this->getOptions($marketplaceSlug, $request)
        );

        $data = $this->priceListPresenter->list(
            $products,
            $marketplaceSlug,
            $this->getOptions($marketplaceSlug, $request),
            $userId
        );

        if ($products->isEmpty()) {
            return view('pages.pricing.prices.empty-list', $data);
        }

        return view('pages.pricing.prices.list', $data);
    }

    private function getOptions(string $store, ShowRequest $request): Options
    {
        $options = $request->getOptions();
        $options->setStore($store);

        return $options;
    }
}
