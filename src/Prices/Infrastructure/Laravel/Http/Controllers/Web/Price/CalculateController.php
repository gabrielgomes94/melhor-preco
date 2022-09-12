<?php

namespace Src\Prices\Infrastructure\Laravel\Http\Controllers\Web\Price;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;
use Src\Marketplaces\Domain\Exceptions\MarketplaceNotFoundException;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Prices\Domain\Exceptions\ProductHasNoPriceInMarketplace;
use Src\Prices\Infrastructure\Laravel\Http\Requests\CalculatePriceRequest;
use Src\Prices\Infrastructure\Laravel\Presenters\Calculator\CalculatorPresenter;
use Src\Prices\Infrastructure\Laravel\Services\CalculatePriceFromProduct;
use Src\Products\Domain\Exceptions\ProductNotFoundException;
use Src\Products\Domain\Models\Product;
use Src\Products\Domain\Repositories\ProductRepository;

class CalculateController extends Controller
{
    public function __construct(
        private readonly CalculatorPresenter $productPresenter,
        private readonly CalculatePriceFromProduct $calculatePriceFromProduct,
        private readonly ProductRepository $productRepository,
        private readonly MarketplaceRepository $marketplaceRepository,
    ) {
    }

    /**
     * @return Application|ViewFactory|View
     * @throws ProductNotFoundException
     * @throws ProductHasNoPriceInMarketplace
     * @throws MarketplaceNotFoundException
     */
    public function __invoke(
        string $storeSlug,
        string $productId,
        CalculatePriceRequest $request
    ): Application|ViewFactory|View
    {
        $userId = $this->getUserId();
        $calculatorForm = $request->transform();

        $marketplace = $this->getMarketplace($storeSlug, $userId);
        $product = $this->getProduct($productId, $userId);
        $priceCalculatedFromProduct = $this->calculatePriceFromProduct->calculate(
            $marketplace,
            $product,
            $calculatorForm
        );

        $presented = $this->productPresenter->present(
            $priceCalculatedFromProduct,
            $request->transform()
        );

        return view('pages.pricing.products.show', $presented);
    }

    /**
     * @throws MarketplaceNotFoundException
     * @todo: transformar esse método numa trait e usar em outros pontos da aplicação
     */
    private function getMarketplace(string $marketplaceSlug, string $userId): Marketplace
    {
        $marketplace = $this->marketplaceRepository->getBySlug($marketplaceSlug, $userId);

        if (!$marketplace) {
            throw new MarketplaceNotFoundException($marketplaceSlug);
        }

        return $marketplace;
    }

    /**
     * @throws ProductNotFoundException
     * @todo: transformar esse método numa trait e usar em outros pontos da aplicação
     */
    public function getProduct(string $productSku, string $userId): Product
    {
        $product = $this->productRepository->get($productSku, $userId);

        if (!$product) {
            throw new ProductNotFoundException($productSku, $userId);
        }

        return $product;
    }
}
