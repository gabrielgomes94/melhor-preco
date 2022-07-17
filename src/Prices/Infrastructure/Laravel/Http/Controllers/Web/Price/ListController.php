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

    /**
     * @throws MarketplaceNotFoundException
     */
    public function __invoke(ShowRequest $request, ?string $marketplaceSlug = null): Application|Factory|View
    {
        $marketplace = $this->getMarketplace($marketplaceSlug);
        $options = $this->getOptions($marketplace->getSlug(), $request);

        $products = $this->listProductsService->listPaginate($options);

        $data = $this->priceListPresenter->list(
            $products,
            $marketplace,
            $options,
            $this->getUserId()
        );

        if ($products->isEmpty()) {
            return view('pages.pricing.prices.empty-list', $data);
        }

        return view('pages.pricing.prices.list', $data);
    }

    private function getOptions(string $store, ShowRequest $request): Options
    {
        $options = $request->transform();
        $options->setStore($store);

        return $options;
    }

    /**
     * @throws MarketplaceNotFoundException
     */
    private function getMarketplace(?string $marketplaceSlug): Marketplace
    {
        if (!$marketplaceSlug) {
            return $this->marketplaceRepository->first($this->getUserId())
                ?? throw new MarketplaceNotFoundException('');
        }

        return $this->marketplaceRepository->getBySlug($marketplaceSlug, $this->getUserId())
            ?? throw new MarketplaceNotFoundException($marketplaceSlug);
    }
}
