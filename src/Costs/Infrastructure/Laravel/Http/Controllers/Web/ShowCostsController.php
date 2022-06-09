<?php

namespace Src\Costs\Infrastructure\Laravel\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Src\Costs\Domain\UseCases\ShowProductCosts;
use Src\Products\Presentation\Presenters\Reports\CostsPresenter;

class ShowCostsController extends Controller
{
    public function __construct(
        private ShowProductCosts $showProductCosts,
        private CostsPresenter $costsPresenter
    ) {
    }

    public function __invoke(string $sku)
    {
        $data = $this->showProductCosts->show($sku);

        return view('pages.costs.products.show', [
            'costs' => $this->costsPresenter->present($data->purchaseItemCosts),
            'product' => [
                'sku' => $data->product->getSku(),
                'name' => $data->product->getName(),
            ]
        ]);
    }
}
