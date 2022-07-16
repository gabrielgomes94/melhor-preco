<?php

namespace Src\Prices\Infrastructure\Laravel\Http\Controllers\Web\Price;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Prices\Infrastructure\Laravel\Http\Requests\PriceList\ShowRequest;
use Src\Prices\Infrastructure\Laravel\Presenters\PriceListPresenter;
use Src\Prices\Infrastructure\Laravel\Services\Products\ListProducts;
use Src\Products\Infrastructure\Laravel\Repositories\Options\Options;

class ListController extends Controller
{
    private ListProducts $listProductsService;
    private PriceListPresenter $priceListPresenter;
    private MarketplaceRepository $marketplaceRepository;
    public function __construct(
        ListProducts $listProductsService,
        PriceListPresenter $priceListPresenter,
        MarketplaceRepository $marketplaceRepository
    ) {
        $this->listProductsService = $listProductsService;
        $this->priceListPresenter = $priceListPresenter;
        $this->marketplaceRepository = $marketplaceRepository;
    }

    /**
     * @return Application|Factory|View
     */
    public function show(ShowRequest $request, ?string $marketplaceSlug = null)
    {
        $userId = auth()->user()->getAuthIdentifier();

        if (!$marketplaceSlug) {
            $marketplaceSlug = $this->marketplaceRepository->first($userId)->getSlug();
        }

        $paginator = $this->listProductsService->listPaginate(
            $this->getOptions($marketplaceSlug, $request)
        );

        $data = $this->priceListPresenter->list($paginator, $marketplaceSlug, $request->all(), $userId);


        return view('pages.pricing.price-list.show', $data);
    }

    private function getOptions(string $store, ShowRequest $request): Options
    {
        $options = $request->getOptions();
        $options->setStore($store);

        return $options;
    }
}
