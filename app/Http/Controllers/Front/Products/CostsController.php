<?php

namespace App\Http\Controllers\Front\Products;

use App\Factories\Product\Product as ProductFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\UpdateCostsRequest;
use App\Repositories\Pricing\Product\Updator;
use App\Repositories\Product\FinderDB;
use Barrigudinha\Product\Product;
use Barrigudinha\Product\Services\Update as UpdateService;
use Illuminate\Http\Request;

class CostsController extends Controller
{
    private FinderDB $repository;
    private Updator $updator;
    private UpdateService $updateService;

    public function __construct(FinderDB $repository, Updator $updator, UpdateService $updateService)
    {
        $this->repository = $repository;
        $this->updator = $updator;
        $this->updateService = $updateService;
    }

    public function edit(Request $request)
    {
        $products = $this->repository->all();

        $products = array_filter($products, function (Product $product) {
            return (int) $product->sku() < 300;
        });

        return view('pages.products.price_costs.edit', ['products' => $products]);
    }

    public function update(string $productId, UpdateCostsRequest $request)
    {
        $productModel = $this->repository->getModel($productId);
        $product = ProductFactory::buildFromModel($productModel);
        $data = $request->transform();
        $product = $this->updateService->updateCosts($product, $data);

        $this->updator->sync($product, $productModel);

        return redirect()->back();
    }
}
