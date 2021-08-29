<?php

namespace App\Http\Controllers\Front\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\EditCostsRequest;
use App\Http\Requests\Product\UpdateCostsRequest;
use App\Services\Pricing\UpdatePrice\Exceptions\UpdatePriceException;
use App\Services\Product\ListProducts;
use App\Services\Product\Update\UpdateCosts;

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
