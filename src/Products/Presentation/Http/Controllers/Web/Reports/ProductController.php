<?php

namespace Src\Products\Presentation\Http\Controllers\Web\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Products\Application\Exceptions\ProductNotFoundException;
use Src\Products\Application\UseCases\ReportProduct;
use Src\Products\Application\UseCases\Reports\ProductsInformation;
use Src\Products\Application\UseCases\Reports\ReportInformations;
use Src\Products\Presentation\Presenters\Reports\ProductReportPresenter;

class ProductController extends Controller
{
    public function __construct(
        private ReportProduct $reportProduct,
        private ProductReportPresenter $productReportPresenter,
        private ProductsInformation $reportInformations
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

        $data = array_merge(
            $data,
            ['redirectLink' => redirect()->back()->getTargetUrl()]
        );

        return view('pages.products.reports.product_details', $data);
    }

    public function informations(Request $request)
    {
        $data = $this->reportInformations->report();

        return view('pages.products.reports.product_information', [
            'data' => $data,
        ]);
    }
}
