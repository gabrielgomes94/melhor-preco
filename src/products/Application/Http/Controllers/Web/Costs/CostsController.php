<?php

namespace Src\Products\Application\Http\Controllers\Web\Costs;

use App\Http\Controllers\Controller;
use Src\Prices\Price\Application\Services\Exceptions\UpdatePriceException;
use Src\Products\Application\Http\Requests\Product\EditCostsRequest;
use Src\Products\Application\Http\Requests\Product\UpdateCostsRequest;
use Src\Products\Application\Services\ListProducts;
use Src\Products\Application\Services\Update\UpdateCosts;

use function redirect;
use function session;
use function view;

class CostsController extends Controller
{
    private UpdateCosts $updateService;
    private ListProducts $listProductsService;

    public function __construct(
        UpdateCosts $updateService,
        ListProducts $listProductsService
    ) {
        $this->updateService = $updateService;
        $this->listProductsService = $listProductsService;
    }

    public function edit(EditCostsRequest $request)
    {
        $paginator = $this->listProductsService->listPaginate($request->getOptions());

        return view('pages.products.price_costs.edit', [
            'paginator' => $paginator,
            'products' => $paginator->items(),
            'sku' => $request->getSku(),
        ]);
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
