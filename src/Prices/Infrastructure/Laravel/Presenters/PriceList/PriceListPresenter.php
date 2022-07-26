<?php

namespace Src\Prices\Infrastructure\Laravel\Presenters\PriceList;

use App\Http\Controllers\Utils\Breadcrumb;
use Illuminate\Pagination\LengthAwarePaginator;
use Src\Marketplaces\Domain\Exceptions\MarketplaceNotFoundException;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Math\MathPresenter;
use Src\Prices\Infrastructure\Laravel\Presenters\PriceList\FilterPresenter;
use Src\Prices\Infrastructure\Laravel\Presenters\PriceList\MarketplacesPresenter;
use Src\Products\Domain\Models\Product\Product;
use Src\Products\Domain\Repositories\CategoryRepository;
use Src\Products\Infrastructure\Laravel\Models\Categories\Category;
use Src\Products\Infrastructure\Laravel\Repositories\Options\Options;

class PriceListPresenter
{
    public function __construct(
        private readonly FilterPresenter       $filterPresenter,
        private readonly MarketplacesPresenter $marketplacesPresenter
    ) {
    }

    public function list(
        LengthAwarePaginator $paginator,
        Marketplace $marketplace,
        Options $options,
        string $userId
    ): array
    {
        return [
            'currentMarketplace' => [
                'name' => $marketplace->getName(),
                'slug' => $marketplace->getSlug(),
            ],
            'filter' => $this->filterPresenter->present($options),
            'marketplaces' => $this->marketplacesPresenter->present($userId),
            'paginator' => $paginator->appends(
                'category',
                $options->getCategoryId() ?? null
            ),
            'products' => $this->presentProducts(
                $paginator->items(),
                $marketplace,
                $options
            ),
        ];
    }

    private function presentProducts(array $items, Marketplace $marketplace, Options $options): array
    {
        $products = collect($items);
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
}