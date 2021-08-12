<?php

namespace App\Http\Controllers\Front\Products;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Utils\Paginator;
use App\Http\Requests\Product\UpdateCostsRequest;
use App\Repositories\Product\ListDB;
use App\Repositories\Product\Options\Options;
use App\Services\Pricing\UpdatePrice\Exceptions\UpdatePriceException;
use App\Services\Product\Update\UpdateCosts;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

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
        $options = $this->setOptions($request);
        $products = $this->repository->list($options);
        $paginator = $this->setPagination($products, $request);

        return view('pages.products.price_costs.edit', [
            'paginator' => $paginator,
            'products' => $paginator->items(),
        ]);
    }

    public function update(string $productId, UpdateCostsRequest $request)
    {
        $data = $request->validated();

        try {
            $this->updateService->execute($productId, $data);

            session()->flash('message', "Preço atualizado com sucesso no produto {$productId}");
        } catch (UpdatePriceException $exception) {
            session()->flash('error', $exception->getMessage());
        }

        return redirect()->back();
    }

    private function setOptions(Request $request): Options
    {
        $perPage = 40;

        return new Options([
            'page' => $request->input('page') ?? 1,
            'perPage' => $perPage,
        ]);
    }

    private function setPagination(iterable $products, Request $request): LengthAwarePaginator
    {
        $options = $this->setOptions($request);

        return $this->paginator->paginate(array: $products, request: $request, count: $this->repository->count($options));
    }
}
