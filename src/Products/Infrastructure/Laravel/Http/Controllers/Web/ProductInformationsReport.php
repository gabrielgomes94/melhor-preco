<?php

namespace Src\Products\Infrastructure\Laravel\Http\Controllers\Web;

use Illuminate\Http\Request;
use Src\Products\Infrastructure\Laravel\Repositories\Reports\GetProductsInformationReport as ReportProductsInformation;
use Src\Products\Infrastructure\Laravel\Models\Categories\Category;
use Src\Products\Domain\Repositories\CategoryRepository;
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
        $data = $this->reportInformations->report($filter, $request->user());
        $userId = auth()->user()->getAuthIdentifier();

        $categories = $this->getCategories($userId);

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

    private function getCategories(string $userId): array
    {
        $categories = $this->categoryRepository->list($userId);
        $categories = collect($categories);

        $categories = $categories->map(function (Category $category) {
            return [
                'name' => $category->getFullName(),
                'category_id' => $category->getCategoryId(),
            ];
        });

        return $categories->sortBy('name')->toArray();
    }
}
