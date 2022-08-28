<?php

namespace Src\Costs\Infrastructure\Laravel\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Src\Costs\Infrastructure\Laravel\Presenters\PurchaseItemsPresenter;
use Src\Costs\Infrastructure\Laravel\Repositories\Repository;
use Src\Products\Domain\Exceptions\ProductNotFoundException;

class ShowCostsController extends Controller
{
    public function __construct(
        private Repository $costsRepository,
        private PurchaseItemsPresenter $purchaseItemsPresenter
    ) {}

    /**
     * @throws ProductNotFoundException
     */
    public function __invoke(string $sku): Application|Factory|View
    {
        $userId = auth()->user()->getAuthIdentifier();
        $data = $this->costsRepository->getProductCosts($sku, $userId);

        return view('pages.costs.products.show', [
            'costs' => $this->purchaseItemsPresenter->presentList($data->purchaseItemCosts),
            'product' => [
                'sku' => $data->product->getSku(),
                'name' => $data->product->getName(),
            ]
        ]);
    }
}
