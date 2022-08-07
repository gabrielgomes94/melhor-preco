<?php

namespace Src\Products\Infrastructure\Laravel\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Products\Domain\Exceptions\ProductNotFoundException;
use Src\Products\Infrastructure\Laravel\Repositories\Reports\GetProductReport;
use Src\Products\Infrastructure\Laravel\Presenters\ProductReportPresenter;

class ProductController extends Controller
{
    public function __construct(
        private GetProductReport       $reportProduct,
        private ProductReportPresenter $productReportPresenter
    ) {
    }

    public function get(Request $request, string $sku)
    {
        $userId = $request->user()->getAuthIdentifier();

        try {
            $data = $this->reportProduct->get($sku, $userId);
            $data = $this->productReportPresenter->present($data);
        } catch (ProductNotFoundException $exception) {
            abort(404);
        }

        $data = array_merge(
            $data,
            ['redirectLink' => redirect()->back()->getTargetUrl()]
        );

        return view('pages.products.reports.product_details', $data);
    }
}
