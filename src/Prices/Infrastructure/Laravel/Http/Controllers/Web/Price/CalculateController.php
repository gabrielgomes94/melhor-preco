<?php

namespace Src\Prices\Infrastructure\Laravel\Http\Controllers\Web\Price;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Math\Percentage;
use Src\Prices\Domain\DataTransfer\CalculatorOptions;
use Src\Prices\Domain\Services\CalculatePrice;
use Src\Prices\Infrastructure\Laravel\Http\Requests\CalculatePriceRequest;
use Src\Prices\Infrastructure\Laravel\Presenters\ProductPresenter;
use Src\Products\Domain\Exceptions\PostNotFoundException;
use Src\Products\Domain\Exceptions\ProductNotFoundException;
use Src\Products\Domain\Repositories\ProductRepository;

class CalculateController extends Controller
{
    public function __construct(
        private MarketplaceRepository $marketplaceRepository,
        private ProductRepository $productRepository,
        private ProductPresenter $productPresenter,
        private CalculatePrice $calculatePrice,
//        private GetPost $getPost
    ) {}

    /**
     * @return Application|ViewFactory|View
     */
    public function __invoke(string $storeSlug, string $productId, CalculatePriceRequest $request)
    {
        try {
//            $data = $this->getPost->get($productId, $storeSlug, $request->transform());
            $userId = auth()->user()->getAuthIdentifier();
            $product = $this->productRepository->get($productId, $userId);
            $marketplace = $this->marketplaceRepository->getBySlug($storeSlug, $userId);

            $data = $request->transform();
            $calculatedPrice = $this->calculatePrice->calculate(
                $product,
                $marketplace,
                $data['price'] ?? 12,
                new CalculatorOptions(
                    $data['discount'] ?? Percentage::fromPercentage(0.0),
                    $data['commission'] ?? null,
                )
            );

            $presented = $this->productPresenter->present($product, $marketplace, $calculatedPrice, $request);
//            $presented = $this->productPresenter->present($data, $request);
        } catch (ProductNotFoundException $exception) {
            abort(404);
        } catch (PostNotFoundException $exception) {
            return view('pages.pricing.products.not-integrated');
        }

        return view(
            'pages.pricing.products.show',
            $presented
        );
    }
}
