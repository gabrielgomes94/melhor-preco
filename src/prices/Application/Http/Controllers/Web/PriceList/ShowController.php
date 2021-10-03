<?php

namespace Src\Prices\Application\Http\Controllers\Web\PriceList;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Utils\Breadcrumb;
use Src\Prices\Application\Http\Requests\PriceList\ShowRequest;
use App\Presenters\Pricing\Product\Presenter as ProductPresenter;
use App\Presenters\Store\Presenter as StorePresenter;
use App\Presenters\Store\Store;
use Src\Prices\Application\Services\Products\ListProducts;
use Barrigudinha\Product\Entities\ProductsCollection;
use Barrigudinha\Product\Utils\Contracts\Options;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;

class ShowController extends Controller
{
    private StorePresenter $storePresenter;
    private ProductPresenter $productPresenter;
    private Breadcrumb $breadcrumb;
    private ListProducts $listProductsService;

    public function __construct(
        StorePresenter $storePresenter,
        ProductPresenter $productPresenter,
        Breadcrumb $breadcrumb,
        ListProducts $listProductsService
    ) {
        $this->storePresenter = $storePresenter;
        $this->productPresenter = $productPresenter;
        $this->breadcrumb = $breadcrumb;
        $this->listProductsService = $listProductsService;
    }

    /**
     * @return Application|Factory|View
     */
    public function show(string $store, ShowRequest $request)
    {
        $paginator = $this->listProductsService->listPaginate($this->getOptions($store, $request));

        return view('pages.pricing.price-list.stores.show', $this->viewData($store, $request, $paginator));
    }

    private function getBreadcrumb(Store $store): array
    {
        return $this->breadcrumb->generate(
            Breadcrumb::priceListIndex(),
            Breadcrumb::priceListByStore($store->name(), $store->slug())
        );
    }

    private function getOptions(string $store, ShowRequest $request): Options
    {
        $options = $request->getOptions();
        $options->setStore($store);

        return $options;
    }

    private function viewData(string $store, ShowRequest $request, LengthAwarePaginator $paginator): array
    {
        $store = $this->storePresenter->present($store);
        $collection = new ProductsCollection($paginator->items());
        $productsPresented = $this->productPresenter->list($collection, $store->slug());

        return [
            'store' => $store,
            'breadcrumb' => $this->getBreadcrumb($store),
            'paginator' => $paginator,
            'products' => $productsPresented,
            'minimumProfit' => $request->input('minProfit') ?? '',
            'maximumProfit' => $request->input('maxProfit') ?? '',
            'sku' => $request->input('sku') ?? '',
        ];
    }
}
