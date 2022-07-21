<?php

namespace Src\Prices\Infrastructure\Laravel\Http\Controllers\Web\Price;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Prices\Domain\Exceptions\UpdatePriceException;
use Src\Prices\Infrastructure\Laravel\Http\Requests\Price\UpdatePriceRequest;
//use Src\Prices\Infrastructure\Laravel\Services\Prices\UpdatePrice as UpdatePriceService;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;

class UpdateController extends Controller
{
    private MarketplaceRepository $marketplaceRepository;
    private UpdatePriceService $updatePriceService;

    public function __construct(MarketplaceRepository $marketplaceRepository, UpdatePriceService $updatePriceService)
    {
        $this->marketplaceRepository = $marketplaceRepository;
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

        if (!$marketplace = $this->marketplaceRepository->getBySlug($data['marketplaceSlug'])) {
            session()->flash('error', 'Loja inválida.');

            return redirect()->back();
        }

        $commission = $data['commissionRate'] ?? null;

        try {
            $this->updatePriceService->updatePrice($product, $marketplace, $data['value'], $commission);
            session()->flash('message', 'Preço atualizado com sucesso.');
        } catch (UpdatePriceException $exception) {
            session()->flash('error', $exception->getMessage());
        }

        return redirect()->back();
    }
}
