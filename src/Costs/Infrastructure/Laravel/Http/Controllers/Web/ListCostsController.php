<?php

namespace Src\Costs\Infrastructure\Laravel\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Src\Costs\Infrastructure\Laravel\Http\Requests\ListProductCostsRequest;
use Src\Costs\Infrastructure\Laravel\Presenters\ListProductCostsPresenter;
use Src\Products\Infrastructure\Laravel\Services\ListProducts;

class ListCostsController extends Controller
{
    public function __construct(
        private readonly ListProducts $listProducts,
        private readonly ListProductCostsPresenter $presenter
    ) {
    }

    public function __invoke(ListProductCostsRequest $request)
    {
        $options = $request->getOptions();
        $data = $this->listProducts->list($options);
        $data = $this->presenter->present($data, $options);

        return view('pages.costs.products.list', $data);
    }
}
