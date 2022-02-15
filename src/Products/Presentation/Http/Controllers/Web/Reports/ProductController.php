<?php

namespace Src\Products\Presentation\Http\Controllers\Web\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Prices\Presentation\Presenters\ProductPresenter;
use Src\Products\Application\Exceptions\ProductNotFoundException;
use Src\Products\Application\UseCases\ReportProduct;

class ProductController extends Controller
{
    public function __construct(
        private ReportProduct      $reportProduct,
        private ProductPresenter $productPresenter
    ) {}

    public function get(Request $request, string $sku)
    {
        try {
            $data = $this->reportProduct->get($sku);
            dd($data);
        } catch (ProductNotFoundException $exception) {
            abort(404);
        }

        return view(
            'pages.products.reports.get_with_stock',
            array_merge(
                $data,
                [
                    'redirectLink' => redirect()->back()->getTargetUrl()
                ]
            )
        );
    }
}
