<?php

namespace App\Http\Controllers\Front\Pricing\Price;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pricing\Price\UpdatePrice;
use App\Repositories\Product\FinderDB;
use App\Services\Product\Update\UpdatePosts as UpdatePriceService;
use App\Services\Pricing\UpdatePrice\Exceptions\UpdatePriceException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class UpdateController extends Controller
{
    private FinderDB $repository;
    private UpdatePriceService $updatePriceService;

    public function __construct(FinderDB $repository, UpdatePriceService $updatePriceService)
    {
        $this->repository = $repository;
        $this->updatePriceService = $updatePriceService;
    }

    /**
     * @return Redirector|RedirectResponse
     */
    public function update(string $productId, string $priceId, UpdatePrice $request)
    {
        $data = $request->validated();

        if (!$product = $this->repository->get($productId)) {
            session()->flash('error', 'Produto não encontrado.');

            return redirect()->back();
        }

        if (!$store = $product->getStore($data['storeSlug'])) {
            session()->flash('error', 'Loja inválida.');

            return redirect()->back();
        }

        try {
            $this->updatePriceService->updatePrice($product, $store, $data['value']);
            session()->flash('message', 'Preço atualizado com sucesso.');
        } catch (UpdatePriceException $exception) {
            session()->flash('error', $exception->getMessage());
        }

        return redirect()->back();
    }
}
