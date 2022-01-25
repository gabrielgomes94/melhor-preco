<?php

namespace Src\Prices\Presentation\Presenters;

use App\Http\Controllers\Utils\Breadcrumb;
use Illuminate\Pagination\LengthAwarePaginator;
use Src\Products\Domain\Models\Categories\Category;
use Src\Products\Domain\Models\Store\Factory;
use Src\Products\Domain\Repositories\Contracts\CategoryRepository;

class PriceListPresenter
{
    private Breadcrumb $breadcrumb;
    private CategoryRepository $categoryRepository;

    public function __construct(
        Breadcrumb $breadcrumb,
        CategoryRepository $categoryRepository
    ) {
        $this->breadcrumb = $breadcrumb;
        $this->categoryRepository = $categoryRepository;
    }

    public function list(LengthAwarePaginator $paginator, string $store, array $parameters)
    {
        $store = new StorePresenter(
            name: Factory::make($store)->getName(),
            slug: $store
        );

        $categories = $this->categoryRepository->list();
        $categories = $categories->map(function(Category $category) {
            return [
                'name' => $category->getFullName(),
                'category_id' => $category->getCategoryId(),
            ];
        })->sortBy('name');

        return [
            'breadcrumb' => $this->getBreadcrumb($store),
            'paginator' => $paginator->appends('category', $parameters['category'] ?? null),
            'products' => $paginator->items(),
            'minimumProfit' => $parameters['minProfit'] ?? null,
            'maximumProfit' => $parameters['maxProfit'] ?? null,
            'sku' => $parameters['sku'] ?? null,
            'store' => $store,
            'filter' => [
                'categories' => $categories->toArray(),
                'minimumProfit' => $parameters['minProfit'] ?? null,
                'maximumProfit' => $parameters['maxProfit'] ?? null,
                'sku' => $parameters['sku'] ?? null,
            ],
            'massCalculation' => [
                'margin' => 00.0,
                'commission' => 0.0,
            ]
        ];
    }

    private function getBreadcrumb(StorePresenter $store): array
    {
        return $this->breadcrumb->generate(
            Breadcrumb::priceListIndex(),
            Breadcrumb::priceListByStore($store->name(), $store->slug())
        );
    }
}
