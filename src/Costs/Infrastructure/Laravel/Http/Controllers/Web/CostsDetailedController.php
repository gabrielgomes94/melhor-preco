<?php

namespace Src\Costs\Infrastructure\Laravel\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Src\Costs\Domain\UseCases\ShowProductCosts;
use Src\Products\Presentation\Presenters\Reports\CostsPresenter;

class CostsDetailedController extends Controller
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
            'costs' => $this->costsPresenter->present($data['costs']),
            'product' => [
                'sku' => $data['product']->getIdentifiers()->getSku(),
                'name' => $data['product']->getDetails()->getName(),
            ]
        ]);
    }
}
