<?php

namespace Src\Products\Presentation\Http\Controllers\Web\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Products\Application\Exceptions\ProductNotFoundException;
use Src\Products\Application\UseCases\ReportProduct;
use Src\Products\Presentation\Presenters\Reports\ProductReportPresenter;

class ProductController extends Controller
{
    public function __construct(
        private ReportProduct $reportProduct,
        private ProductReportPresenter $productReportPresenter
    ) {
    }

    public function get(Request $request, string $sku)
    {
        try {
            $data = $this->reportProduct->get($sku);
            $data = $this->productReportPresenter->present($data);
        } catch (ProductNotFoundException $exception) {
            abort(404);
        }

        return view(
            'pages.products.reports.product_infos',
            array_merge(
                $data,
                [
                    'redirectLink' => redirect()->back()->getTargetUrl()
                ]
            )
        );
    }
}
