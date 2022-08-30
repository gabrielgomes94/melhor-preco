<?php

namespace Src\Products\Infrastructure\Laravel\Http\Controllers\Web\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Src\Products\Domain\Exceptions\ProductNotFoundException;
use Src\Products\Infrastructure\Laravel\Repositories\Reports\GetProductReport;
use Src\Products\Infrastructure\Laravel\Presenters\ProductReportPresenter;

class ProductDetailsController extends Controller
{
    public function __construct(
        private GetProductReport $reportProduct,
        private ProductReportPresenter $productReportPresenter
    ) {
    }

    public function get(Request $request, string $sku): View|Factory
    {
        $userId = $request->user()->getAuthIdentifier();

        try {
            $data = $this->reportProduct->get($sku, $userId);
            $data = $this->productReportPresenter->present($data);
        } catch (ProductNotFoundException $exception) {
            throw new ProductNotFoundException($sku, $userId);
        }

        $data = array_merge(
            $data,
            ['redirectLink' => redirect()->back()->getTargetUrl()]
        );

        return view('pages.products.reports.product_details', $data);
    }
}
