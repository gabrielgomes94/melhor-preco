<?php

namespace Src\Prices\Price\Application\Http\Controllers\Web\Price;

use App\Http\Controllers\Controller;
use Src\Prices\Price\Application\Http\Requests\Price\UpdatePriceRequest;
use Src\Products\Domain\Models\Product\Product;
use Src\Products\Application\Services\Update\UpdatePosts as UpdatePriceService;
use Src\Prices\Price\Application\Services\Exceptions\UpdatePriceException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class UpdateController extends Controller
{
    private UpdatePriceService $updatePriceService;

    public function __construct(UpdatePriceService $updatePriceService)
    {
        $this->updatePriceService = $updatePriceService;
    }

    /**
     * @return Redirector|RedirectResponse
     */
    public function update(string $productId, string $priceId, UpdatePriceRequest $request)
    {
        $data = $request->validated();

        if (!$product = Product::find($productId)) {
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
