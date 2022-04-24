<?php

namespace Src\Prices\Presentation\Http\Controllers\Web\Price;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;
use Src\Calculator\Presentation\Http\Requests\CalculatePriceRequest;
use Src\Prices\Domain\UseCases\Contracts\GetPost;
use Src\Prices\Presentation\Presenters\ProductPresenter;
use Src\Products\Application\Exceptions\PostNotFoundException;
use Src\Products\Application\Exceptions\ProductNotFoundException;

class CalculateController extends Controller
{
    public function __construct(
        private ProductPresenter $productPresenter,
        private GetPost $getPost
    ) {}

    /**
     * @return Application|ViewFactory|View
     */
    public function __invoke(string $storeSlug, string $productId, CalculatePriceRequest $request)
    {
        try {
            $data = $this->getPost->get($productId, $storeSlug, $request->transform());
            $presented = $this->productPresenter->present($data, $request);
        } catch (ProductNotFoundException $exception) {
            abort(404);
        } catch (PostNotFoundException $exception) {
            return view('pages.pricing.products.not-integrated');
        }

//        dd($presented);

        return view(
            'pages.pricing.products.show',
            $presented
        );
    }
}
