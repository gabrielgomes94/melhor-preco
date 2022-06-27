<?php

namespace Src\Prices\Infrastructure\Laravel\Presentation\Http\Controllers\Web\PriceLog;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Src\Prices\Infrastructure\Laravel\Presentation\Http\Requests\PriceLog\PriceLogRequest;
use Src\Prices\Infrastructure\Laravel\Presentation\Presenters\PriceLogPresenter;
use Src\Prices\Infrastructure\Laravel\Services\PriceLog\ListProducts;

class PriceLogController extends Controller
{
    private ListProducts $listProductsService;
    private PriceLogPresenter $listPresenter;

    public function __construct(ListProducts $listProductsService, PriceLogPresenter $listPresenter)
    {
        $this->listProductsService = $listProductsService;
        $this->listPresenter = $listPresenter;
    }

    /**
     * @return Application|Factory|View
     */
    public function lastUpdatedProducts(string $storeSlug, PriceLogRequest $request)
    {
        $products = $this->listProductsService->listPaginate($storeSlug, (int) $request->input('page') ?? 1);
        $data = $this->listPresenter->list($products, $storeSlug);

        return view('pages.pricing.price-log.last-updated-products', $data);
    }
}
