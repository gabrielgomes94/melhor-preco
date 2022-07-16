<?php

namespace Src\Prices\Infrastructure\Laravel\Presenters;

use App\Http\Controllers\Utils\Breadcrumb;
use Illuminate\Pagination\LengthAwarePaginator;
use Src\Marketplaces\Domain\Exceptions\MarketplaceNotFoundException;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Math\MathPresenter;
use Src\Products\Domain\Models\Product\Product;
use Src\Products\Domain\Repositories\CategoryRepository;
use Src\Products\Infrastructure\Laravel\Models\Categories\Category;
use Src\Products\Infrastructure\Laravel\Repositories\Options\Options;

class PriceListPresenter
{
    public function __construct(
        private readonly Breadcrumb $breadcrumb,
        private readonly CategoryRepository $categoryRepository,
        private readonly MarketplaceRepository $marketplaceRepository
    ) {
    }

    public function list(LengthAwarePaginator $paginator, string $marketplaceSlug, Options $options, string $userId)
    {
        $marketplaces = $this->presentMarketplaces($userId);
        if (!$marketplace = $this->marketplaceRepository->getBySlug($marketplaceSlug, $userId)) {
            throw new MarketplaceNotFoundException($marketplaceSlug);
        }

        $products = $this->presentProducts($paginator->items(), $marketplace, $options);

        return [
            'breadcrumb' => $this->getBreadcrumb($marketplace),
            'currentMarketplace' => [
                'name' => $marketplace->getName(),
                'slug' => $marketplace->getSlug(),
            ],
            'filter' => $this->presentFilter($options, $userId),
            'marketplaces' => $marketplaces,
            'paginator' => $paginator->appends('category', $options->getCategoryId() ?? null),
            'products' => $products,
        ];
    }

    private function getBreadcrumb(Marketplace $marketplace): array
    {
        return $this->breadcrumb->generate(
            Breadcrumb::priceListIndex(),
            Breadcrumb::priceListByStore($marketplace->getName(), $marketplace->getSlug())
        );
    }

    private function presentProducts(array $items, Marketplace $marketplace, Options $options): array
    {
        $products = collect($items);


        if ($options->hasProfitFilters()) {
            $products = $products->filter(
                function(Product $product) use ($marketplace, $options) {
                    $price = $product->getPrice($marketplace);
                    $margin = $price->getMargin()->get();

                    return $margin >= $options->minimumProfit() && $margin <= $options->maximumProfit();
                }
            );
        }

        $products = $products->transform(function (Product $product) use ($marketplace, $options) {
            $price = $product->getPrice($marketplace);
            $margin = $price?->getMargin()
                ? MathPresenter::percentage($price?->getMargin())
                : null;

            return [
                'sku' => $product->getIdentifiers()->getSku(),
                'name' => $product->getDetails()->getName(),
                'price' => MathPresenter::money($price?->getValue()),
                'profit' => MathPresenter::money($price?->getProfit()),
                'margin' => $margin,
                'quantity' => $product->getQuantity(),
                'variations' => $this->presentProducts(
                    $product->getVariations()?->get() ?? [],
                    $marketplace,
                    $options
                )
            ];
        });

        return $products->toBase()->toArray();
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

    public function presentFilter(Options $options, string $userId): array
    {
        $categories = $this->presentCategories($userId);

        return [
            'categories' => $categories,
            'minimumProfit' => $options->minimumProfit,
            'maximumProfit' => $options->maximumProfit,
            'sku' => $options->sku() ?? null,
        ];
    }

    public function presentMarketplaces(string $userId): array
    {
        $marketplaces = $this->marketplaceRepository->list($userId);
        $marketplaces = collect($marketplaces);

        return $marketplaces->map(
            fn (Marketplace $marketplace) => [
                'slug' => $marketplace->getSlug(),
                'name' => $marketplace->getName(),
            ]
        )->toArray();
    }
}
