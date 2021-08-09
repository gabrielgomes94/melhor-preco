<?php

namespace App\Http\Controllers\Front\Products;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Utils\Paginator;
use App\Http\Requests\Product\UpdateCostsRequest;
use App\Models\Product;
use App\Repositories\Product\ListDB;
use App\Repositories\Product\Options\Options;
use App\Services\Product\Update\UpdateCosts;
use Illuminate\Http\Request;

class CostsController extends Controller
{
    private ListDB $repository;
    private Paginator $paginator;
    private UpdateCosts $updateService;

    public function __construct(
        ListDB $repository,
        Paginator $paginator,
        UpdateCosts $updateService
    ) {
        $this->repository = $repository;
        $this->paginator = $paginator;
        $this->updateService = $updateService;
    }

    public function edit(Request $request)
    {
        $perPage = 40;
        $options = new Options([
            'page' => $request->input('page') ?? 1,
            'perPage' => $perPage,
        ]);
        $products = $this->repository->all($options);

        $paginator = $this->paginator->paginate($products['items'], $request, $perPage, $products['total']);

        return view('pages.products.price_costs.edit', [
            'paginator' => $paginator,
            'products' => $paginator->items(),
        ]);
    }

    public function update(string $productId, UpdateCostsRequest $request)
    {
        $data = $request->validated();
        $this->updateService->execute($productId, $data);

        return redirect()->back();
    }
}
