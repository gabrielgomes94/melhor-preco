<?php

namespace Src\Costs\Presentation\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Costs\Application\UseCases\ShowProductCosts;
use Src\Costs\Domain\UseCases\UpdateCosts;
use Src\Prices\Application\Services\Exceptions\UpdatePriceException;
use Src\Products\Presentation\Http\Requests\Product\EditCostsRequest;
use Src\Products\Presentation\Http\Requests\Product\UpdateCostsRequest;
use Src\Products\Application\UseCases\ListProducts;
use Src\Products\Presentation\Presenters\Reports\CostsPresenter;

class CostsController extends Controller
{
    public function __construct(
        private UpdateCosts $updateService,
        private ListProducts $listProducts,
        private ShowProductCosts $showProductCosts,
        private CostsPresenter $costsPresenter
    ) {
    }

    public function list(EditCostsRequest $request)
    {
        $data = $this->listProducts->list($request->getOptions());


        return view('pages.costs.products.list', $data);
    }

    public function update(string $productId, UpdateCostsRequest $request)
    {
        try {
            $this->updateService->execute($productId, $request->validated());

            session()->flash('message', "Produto {$productId} teve seu custo atualizado com sucesso.");
        } catch (UpdatePriceException $exception) {
            session()->flash('error', $exception->getMessage());
        }

        return redirect()->back();
    }

    public function show(Request $request, string $sku)
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
