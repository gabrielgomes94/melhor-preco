<?php

namespace Src\Prices\Application\Http\Controllers\Web\Price;

use App\Http\Controllers\Controller;
use Src\Prices\Application\Http\Requests\Price\UpdatePrice;
use App\Repositories\Product\GetDB;
use App\Services\Product\Update\UpdatePosts as UpdatePriceService;
use Src\Prices\Application\Services\UpdatePrice\Exceptions\UpdatePriceException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class UpdateController extends Controller
{
    private GetDB $repository;
    private UpdatePriceService $updatePriceService;

    public function __construct(GetDB $repository, UpdatePriceService $updatePriceService)
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
