<?php

namespace Src\Prices\Infrastructure\Laravel\Presenters\PriceList;

use Illuminate\Pagination\LengthAwarePaginator;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Math\Transformers\NumberTransformer;
use Src\Products\Domain\Models\Product;
use Src\Products\Infrastructure\Laravel\Repositories\Options\Options;

class PriceListPresenter
{
    public function __construct(
        private readonly FilterPresenter $filterPresenter,
        private readonly MarketplacesPresenter $marketplacesPresenter
    ) {
    }

    public function list(
        LengthAwarePaginator $paginator,
        Marketplace $marketplace,
        Options $options
    ): array {
        return [
            'currentMarketplace' => [
                'name' => $marketplace->getName(),
                'slug' => $marketplace->getSlug(),
            ],
            'filter' => $this->filterPresenter->present($options),
            'marketplaces' => $this->marketplacesPresenter->present($options->getUserId()),
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
                ? NumberTransformer::toPercentage($price?->getMargin())
                : null;

            return [
                'sku' => $product->getSku(),
                'name' => $product->getName(),
                'price' => NumberTransformer::toMoney($price?->getValue()),
                'profit' => NumberTransformer::toMoney($price?->getProfit()),
                'margin' => $margin,
                'quantity' => $product->getQuantity(),
                'variations' => $this->presentProducts(
                    $product->getVariations()?->get() ?? [],
                    $marketplace,
                    $options
                ),
                'parentSku' => $product->getParentSku(),
            ];
        });


        return $products->toArray();
    }
}
