<?php

namespace Src\Costs\Infrastructure\Laravel\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Costs\Domain\UseCases\ShowProductCosts;
use Src\Costs\Domain\UseCases\Contracts\UpdateCosts;
use Src\Prices\Application\Services\Exceptions\UpdatePriceException;
use Src\Products\Presentation\Http\Requests\Product\EditCostsRequest;
use Src\Products\Presentation\Http\Requests\Product\UpdateCostsRequest;
use Src\Products\Application\UseCases\ListProducts;
use Src\Products\Presentation\Presenters\Reports\CostsPresenter;

class CostsController extends Controller
{
    public function __construct(
        private UpdateCosts $updateService,
        private ListProducts $listProducts
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
}
