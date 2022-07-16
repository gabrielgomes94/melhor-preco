<?php

namespace Src\Prices\Infrastructure\Laravel\Presenters;

use App\Http\Controllers\Utils\Breadcrumb;
use Illuminate\Pagination\LengthAwarePaginator;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Math\MathPresenter;
use Src\Products\Domain\Models\Product\Product;
use Src\Products\Domain\Repositories\CategoryRepository;
use Src\Products\Infrastructure\Laravel\Models\Categories\Category;

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

    public function list(LengthAwarePaginator $paginator, string $store, array $parameters, string $userId)
    {
        $store = new StorePresenter(
            name: $store,
            slug: $store
        );

        $marketplaces = $this->marketplaceRepository->list($userId);
        $marketplaces = collect($marketplaces);
        $marketplaces = $marketplaces->map(function(Marketplace $marketplace) {
            return [
                'slug' => $marketplace->getSlug(),
                'name' => $marketplace->getName(),
            ];
        })->toArray();

        $marketplace = $this->marketplaceRepository->getBySlug($store->slug(), $userId);
        $products = $this->presentProducts($paginator->items(), $marketplace);

        return [
            'breadcrumb' => $this->getBreadcrumb($marketplace),
            'paginator' => $paginator->appends('category', $parameters['category'] ?? null),
            'products' => $products,
            'sku' => $parameters['sku'] ?? null,
            'store' => $store,
            'filter' => $this->presentFilter($parameters, $userId),
            'marketplaces' => $marketplaces,
            'currentMarketplace' => [
                'name' => $marketplace->getName(),
                'slug' => $marketplace->getSlug(),
            ],
        ];
    }

    private function getBreadcrumb(Marketplace $marketplace): array
    {
        return $this->breadcrumb->generate(
            Breadcrumb::priceListIndex(),
            Breadcrumb::priceListByStore($marketplace->getName(), $marketplace->getSlug())
        );
    }

    private function presentProducts(array $items, Marketplace $marketplace): array
    {
        $products = collect($items);

        return $products->transform(function (Product $product) use ($marketplace) {
            $price = $product->getPrice($marketplace);

            return [
                'sku' => $product->getIdentifiers()->getSku(),
                'name' => $product->getDetails()->getName(),
                'price' => MathPresenter::money($price?->getValue()),
                'profit' => MathPresenter::money($price?->getProfit()),
                'margin' => $price?->getMargin() ?? null,
                'quantity' => $product->getQuantity(),
                'variations' => $this->presentProducts($product->getVariations()?->get() ?? [], $marketplace)
            ];
        })->toArray();
    }

    public function presentCategories(string $userId): array
    {
        $categories = $this->categoryRepository->list($userId);
        $categories = collect($categories);

        return $categories->map(
            fn (Category $category) => [
                'name' => $category->getFullName(),
                'category_id' => $category->getCategoryId(),
            ]
        )->sortBy('name')->toArray();
    }

    public function presentFilter(array $parameters, string $userId): array
    {
        $categories = $this->presentCategories($userId);

        return [
            'categories' => $categories,
            'minimumProfit' => $parameters['minProfit'] ?? null,
            'maximumProfit' => $parameters['maxProfit'] ?? null,
            'sku' => $parameters['sku'] ?? null,
        ];
    }
}
