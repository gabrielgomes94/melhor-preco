<?php

namespace Src\Costs\Presentation\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Costs\Domain\UseCases\UpdateCosts;
use Src\Prices\Price\Application\Services\Exceptions\UpdatePriceException;
use Src\Products\Application\Http\Requests\Product\EditCostsRequest;
use Src\Products\Application\Http\Requests\Product\UpdateCostsRequest;
use Src\Products\Application\UseCases\ListProducts;

class CostsController extends Controller
{
    private UpdateCosts $updateService;
    private ListProducts $listProducts;

    public function __construct(
        UpdateCosts $updateService,
        ListProducts $listProducts
    ) {
        $this->updateService = $updateService;
        $this->listProducts =  $listProducts;
    }

    public function edit(EditCostsRequest $request)
    {
        $data = $this->listProducts->list($request->getOptions());

        return view('pages.costs.edit', $data);
    }

    // @todo: mover esse mótodo para um controller proprio ded PurchaseInvoices
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
