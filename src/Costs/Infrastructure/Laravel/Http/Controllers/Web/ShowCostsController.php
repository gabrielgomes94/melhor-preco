<?php

namespace Src\Costs\Infrastructure\Laravel\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Src\Costs\Domain\UseCases\ShowProductCosts;
use Src\Costs\Infrastructure\Laravel\Presenters\PurchaseItemsPresenter;
use Src\Products\Domain\Exceptions\ProductNotFoundException;

class ShowCostsController extends Controller
{
    public function __construct(
        private ShowProductCosts $showProductCosts,
        private PurchaseItemsPresenter $purchaseItemsPresenter
    ) {
    }

    /**
     * @return Application|Factory|View
     * @throws ProductNotFoundException
     */
    public function __invoke(string $sku)
    {
        $userId = auth()->user()->getAuthIdentifier();
        $data = $this->showProductCosts->show($sku, $userId);

        return view('pages.costs.products.show', [
            'costs' => $this->purchaseItemsPresenter->presentList($data->purchaseItemCosts),
            'product' => [
                'sku' => $data->product->getSku(),
                'name' => $data->product->getName(),
            ]
        ]);
    }
}
