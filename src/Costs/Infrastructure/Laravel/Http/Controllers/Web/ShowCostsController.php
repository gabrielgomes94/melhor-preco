<?php

namespace Src\Costs\Infrastructure\Laravel\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Src\Costs\Domain\UseCases\ShowProductCosts;
use Src\Products\Infrastructure\Laravel\Presenters\CostsPresenter;

class ShowCostsController extends Controller
{
    public function __construct(
        private ShowProductCosts $showProductCosts,
        private CostsPresenter $costsPresenter
    ) {
    }

    /**
     * @todo: handle product not found exception. maybe handle this exception globally
     * @return Application|Factory|View
     * @throws \Src\Products\Domain\Exceptions\ProductNotFoundException
     */
    public function __invoke(string $sku)
    {
        $userId = auth()->user()->getAuthIdentifier();
        $data = $this->showProductCosts->show($sku, $userId);

        return view('pages.costs.products.show', [
            'costs' => $this->costsPresenter->present($data->purchaseItemCosts),
            'product' => [
                'sku' => $data->product->getSku(),
                'name' => $data->product->getName(),
            ]
        ]);
    }
}
