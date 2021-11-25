<?php

namespace Src\Prices\Price\Application\Http\Controllers\Web\PriceList;

use App\Http\Controllers\Controller;
use Src\Prices\Price\Application\Http\Requests\PriceList\ShowRequest;
use Src\Prices\Price\Application\Services\Products\ListProducts;
use Src\Prices\Price\Presentation\Presenters\PriceListPresenter;
use Src\Products\Domain\Utils\Contracts\Options;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class ShowController extends Controller
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
        $paginator = $this->listProductsService->listPaginate($this->getOptions($store, $request));
        $data = $this->priceListPresenter->list($paginator, $store, $request->all());

        return view('pages.pricing.price-list.stores.show', $data);
    }

    private function getOptions(string $store, ShowRequest $request): Options
    {
        $options = $request->getOptions();
        $options->setStore($store);

        return $options;
    }
}
