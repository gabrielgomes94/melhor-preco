<?php

namespace Src\Prices\Infrastructure\Laravel\Presentation\Http\Controllers\Web\Price;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Src\Prices\Infrastructure\Laravel\Presentation\Http\Requests\PriceList\ShowRequest;
use Src\Prices\Infrastructure\Laravel\Presentation\Presenters\PriceListPresenter;
use Src\Prices\Infrastructure\Laravel\Services\Products\ListProducts;
use Src\Products\Infrastructure\Laravel\Repositories\Options\Options;

class ListController extends Controller
{
    private ListProducts $listProductsService;
    private PriceListPresenter $priceListPresenter;

    public function __construct(
        ListProducts $listProductsService,
        PriceListPresenter $priceListPresenter
    ) {
        $this->listProductsService = $listProductsService;
        $this->priceListPresenter = $priceListPresenter;
    }

    /**
     * @return Application|Factory|View
     */
    public function show(string $store, ShowRequest $request)
    {
        $userId = auth()->user()->getAuthIdentifier();
        $paginator = $this->listProductsService->listPaginate(
            $this->getOptions($store, $request)
        );

        $data = $this->priceListPresenter->list($paginator, $store, $request->all(), $userId);


        return view('pages.pricing.price-list.show', $data);
    }

    private function getOptions(string $store, ShowRequest $request): Options
    {
        $options = $request->getOptions();
        $options->setStore($store);

        return $options;
    }
}
