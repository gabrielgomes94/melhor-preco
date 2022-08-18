<?php

namespace Src\Costs\Infrastructure\Laravel\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Src\Costs\Infrastructure\Laravel\Http\Requests\ListProductCostsRequest;
use Src\Costs\Infrastructure\Laravel\Presenters\ListProductCostsPresenter;
use Src\Products\Infrastructure\Laravel\Repositories\ProductRepository;

class ListCostsController extends Controller
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly ListProductCostsPresenter $presenter
    ) {
    }

    public function __invoke(ListProductCostsRequest $request)
    {
        $options = $request->getOptions();
        $data = $this->productRepository->allFiltered($options, $this->getUserId());
        $data = $this->presenter->present($data, $options);

        return view('pages.costs.products.list', $data);
    }
}
