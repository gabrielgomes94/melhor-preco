<?php

namespace Src\Prices\Presentation\Presenters;

use App\Http\Controllers\Utils\Breadcrumb;
use Illuminate\Pagination\LengthAwarePaginator;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Products\Infrastructure\Laravel\Models\Categories\Category;
use Src\Products\Domain\Repositories\CategoryRepository;

class PriceListPresenter
{
    private Breadcrumb $breadcrumb;
    private CategoryRepository $categoryRepository;
    private MarketplaceRepository $marketplaceRepository;

    public function __construct(
        Breadcrumb $breadcrumb,
        CategoryRepository $categoryRepository,
        MarketplaceRepository $marketplaceRepository
    ) {
        $this->breadcrumb = $breadcrumb;
        $this->categoryRepository = $categoryRepository;
        $this->marketplaceRepository = $marketplaceRepository;
    }

    public function list(LengthAwarePaginator $paginator, string $store, array $parameters)
    {
        $store = new StorePresenter(
            name: $store,
            slug: $store
        );

        $categories = $this->categoryRepository->list();
        $categories = $categories->map(function (Category $category) {
            return [
                'name' => $category->getFullName(),
                'category_id' => $category->getCategoryId(),
            ];
        })->sortBy('name');

        $marketplaces = $this->marketplaceRepository->list();
        $marketplaces = $marketplaces->map(function(Marketplace $marketplace) {
            return [
                'slug' => $marketplace->getSlug(),
                'name' => $marketplace->getName(),
            ];
        });

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
            ],
            'marketplaces' => $marketplaces,
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
