<?php

namespace Src\Prices\Infrastructure\Laravel\Presentation\Presenters;

use App\Http\Controllers\Utils\Breadcrumb;
use Illuminate\Pagination\LengthAwarePaginator;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
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

        $categories = $this->categoryRepository->list($userId);
        $categories = collect($categories);
        $categories = $categories->map(function (Category $category) {
            return [
                'name' => $category->getFullName(),
                'category_id' => $category->getCategoryId(),
            ];
        })->sortBy('name');

        $marketplaces = $this->marketplaceRepository->list($userId);
        $marketplaces = collect($marketplaces);
        $marketplaces = $marketplaces->map(function(Marketplace $marketplace) {
            return [
                'slug' => $marketplace->getSlug(),
                'name' => $marketplace->getName(),
            ];
        });


        $marketplace = $this->marketplaceRepository->getBySlug($store->slug(), $userId);
        $products = $this->presentProducts($paginator->items(), $marketplace);

        return [
            'breadcrumb' => $this->getBreadcrumb($store),
            'paginator' => $paginator->appends('category', $parameters['category'] ?? null),
            'products' => $products,
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

    private function presentProducts(array $items, Marketplace $marketplace): array
    {
        $products = collect($items);

        return $products->transform(function (Product $product) use ($marketplace) {
            $price = $product->getPrice($marketplace);

            return [
                'sku' => $product->getIdentifiers()->getSku(),
                'name' => $product->getDetails()->getName(),
                'price' => $price->getValue(),
                'profit' => $price->getProfit(),
                'margin' => $price->getMargin(),
                'quantity' => $product->getQuantity(),
                'variations' => $this->presentProducts($product->getVariations()?->get() ?? [], $marketplace)
            ];
        })->toArray();
    }
}
