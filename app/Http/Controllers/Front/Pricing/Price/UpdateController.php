<?php

namespace App\Http\Controllers\Front\Pricing\Price;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pricing\Price\UpdatePrice;
use App\Repositories\Product\FinderDB;
use App\Services\Product\Update\UpdatePosts as UpdatePriceService;
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

        // To Do: mover sa lógicas abaixo para um service: GetProductService
        if (!$product = $this->repository->get($productId)) {
            // To Do: Mostrar erro
        }

        if (!$store = $product->getStore($data['storeSlug'])) {
            // To Do: Mostrar erro
        }

        $this->updatePriceService->updatePrice($product, $store, $data['value']);

        /// To Do: Mostrar mensagem de sucesso
        return redirect()->back();
    }
}
