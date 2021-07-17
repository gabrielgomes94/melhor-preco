<?php

namespace App\Http\Controllers\Front\Products;

use App\Factories\Product\Product as ProductFactory;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Utils\Paginator;
use App\Http\Requests\Product\UpdateCostsRequest;
use App\Repositories\Pricing\Product\Updator;
use App\Repositories\Product\FinderDB;
//use Barrigudinha\Product\Services\Update as UpdateService;
use App\Services\Product\UpdateCosts;
use Illuminate\Http\Request;

class CostsController extends Controller
{
    private FinderDB $repository;
    private Paginator $paginator;
    private Updator $updator;
    private UpdateCosts $updateService;

    public function __construct(
        FinderDB $repository,
        Paginator $paginator,
        Updator $updator,
        UpdateCosts $updateService
    ) {
        $this->repository = $repository;
        $this->paginator = $paginator;
        $this->updator = $updator;
        $this->updateService = $updateService;
    }

    public function edit(Request $request)
    {
        $products = $this->repository->all();

        $paginator = $this->paginator->paginate($products, $request);

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
