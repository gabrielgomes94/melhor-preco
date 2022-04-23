<?php

namespace Src\Prices\Presentation\Http\Controllers\Web\Price;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;
use Src\Calculator\Domain\Services\Contracts\CalculatorOptions;
use Src\Calculator\Domain\UseCases\Contracts\CalculatePrice;
use Src\Calculator\Presentation\Http\Requests\CalculatePriceRequest;
use Src\Math\Percentage;
use Src\Prices\Domain\UseCases\Contracts\ShowPrice;
use Src\Prices\Presentation\Presenters\ProductPresenter;
use Src\Products\Application\Exceptions\PostNotFoundException;
use Src\Products\Application\Exceptions\ProductNotFoundException;

class CalculateController extends Controller
{
    public function __construct(
        private ProductPresenter $productPresenter,
        private CalculatePrice $calculatePriceUseCase,
        private ShowPrice $showPrice
    ) {}

    /**
     * @return Application|ViewFactory|View
     */
    public function __invoke(string $storeSlug, string $productId, ?CalculatePriceRequest $request)
    {
        try {
            $data = $this->showPrice->show($productId, $storeSlug);

        } catch (ProductNotFoundException $exception) {
            abort(404);
        } catch (PostNotFoundException $exception) {
            return view('pages.pricing.products.not-integrated');
        }

        if (empty($request->all())) {
            $post = $this->calculatePriceUseCase->calculate([
                'productId' => $productId,
                'storeSlug' => $storeSlug,
                'price' => (float) $data['post']->getPrice()->getValue(),
                'commission' => $data['post']->getPrice()->getCommission(),
                'options' => [
//                    CalculatorOptions::DISCOUNT_RATE => Percentage::fromPercentage($data['discount'] ?? 0),
//                    CalculatorOptions::FREE_FREIGHT => $this->hasFreeFreight(),
                ]
            ]);
        } else {
            $post = $this->calculatePriceUseCase->calculate($request->transform());
        }

//        dd($this->productPresenter->presentNew($data['product'], $post));

        return view(
            'pages.pricing.products.show',
            $this->productPresenter->presentNew($data['product'], $post)
        );
    }
}
