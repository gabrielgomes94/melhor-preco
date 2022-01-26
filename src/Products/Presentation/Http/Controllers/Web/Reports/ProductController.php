<?php

namespace Src\Products\Presentation\Http\Controllers\Web\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use Src\Costs\Infrastructure\Eloquent\Repository;
use Src\Costs\Application\UseCases\ShowProductCosts;
use Src\Integrations\Bling\Base\Responses\ErrorResponse;
use Src\Products\Domain\Repositories\Contracts\ProductRepository;
use Src\Sales\Application\UseCases\Reports\ReportProductSales;

//use Src\Products\Infrastructure\Bling\ProductRepository;

class ProductController extends Controller
{
    private ProductRepository $repository;
    private ShowProductCosts $showProductCosts;
    private ReportProductSales $reportProductSales;

    public function __construct(
        ProductRepository $repository,
        ShowProductCosts $showProductCosts,
        ReportProductSales $reportProductSales
    ) {
        $this->repository = $repository;
        $this->showProductCosts = $showProductCosts;
        $this->reportProductSales = $reportProductSales;
    }


    // @todo: mover lógica par UseCase
    public function get(Request $request, string $sku)
    {
        $product = $this->repository->get($sku);

        if (!$product) {
            abort(404);
        }

        $costs = $this->showProductCosts->show($sku);
        $sales = $this->reportProductSales->report($sku);

        return view('pages.products.reports.get_with_stock', [
            'costs' => $costs,
            'product' => $product->toArray(),
            'sales' => $sales,
        ]);
    }

    private function transform(array $data): array
    {
        return [
            'sku' => $data['sku'],
            'name' => $data['name'],
            'brand' => $data['brand'],
            'images' => $data['images'] ?? [],
            'stock' => $data['stock'] ?? null,
        ];
    }

    private function transformErrors(array $errors): string
    {
        return array_shift($errors);
    }
}
