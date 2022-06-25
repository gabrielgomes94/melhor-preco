<?php

namespace Src\Products\Infrastructure\Laravel\Http\Controllers\Web;

use Illuminate\Http\Request;
use Src\Products\Application\UseCases\Reports\ProductsInformation as ReportProductsInformation;
use Src\Products\Domain\Models\Categories\Category;
use Src\Products\Domain\Repositories\Contracts\CategoryRepository;
use Src\Products\Infrastructure\Laravel\Http\Requests\ReportProductRequest;

class ProductInformationsReport
{
    public function __construct(
        private ReportProductsInformation $reportInformations,
        private CategoryRepository $categoryRepository
    ) {
    }

    public function __invoke(ReportProductRequest $request)
    {
        $filter = $request->transform();
        $data = $this->reportInformations->report($filter);

        $categories = $this->getCategories();

        return view('pages.products.reports.product_information', [
            'data' => $data['data'],
            'paginator' => $data['paginator'],
            'filter' => [
                'categories' => $categories,
                'sku' => $request->input('sku') ?? null,
                'beginDate' => '',
                'endDate' => '',
            ],
        ]);
    }

    private function getCategories(): array
    {
        $categories = $this->categoryRepository->list();

        $categories = $categories->map(function (Category $category) {
            return [
                'name' => $category->getFullName(),
                'category_id' => $category->getCategoryId(),
            ];
        });

        return $categories->sortBy('name')->toArray();
    }
}
