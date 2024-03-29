<?php

namespace Src\Prices\Infrastructure\Laravel\Presenters\PriceList;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Math\Transformers\NumberTransformer;
use Src\Math\Percentage;
use Src\Prices\Domain\DataTransfer\ListPricesCalculated;
use Src\Prices\Domain\DataTransfer\PriceCalculatedFromProduct;
use Src\Products\Domain\Models\Product;
use Src\Products\Infrastructure\Laravel\Repositories\Options\Options;

class MassCalculatedPricesPresenter
{
    public function __construct(
        private readonly FilterPresenter $filterPresenter,
        private readonly MarketplacesPresenter $marketplacesPresenter,
    ) {
    }

    public function present(ListPricesCalculated $pricesCalculated, string $userId): array
    {
        $marketplace = $pricesCalculated->marketplace;

        $products = collect($pricesCalculated->calculatedPrices)
            ->map(function (PriceCalculatedFromProduct $priceCalculatedFromProduct) {
                return $priceCalculatedFromProduct->product;
            });

        $paginator = new LengthAwarePaginator($products->all(), $products->count(), 40, 1);

        return [
            'currentMarketplace' => [
                'name' => $marketplace->getName(),
                'slug' => $marketplace->getSlug(),
            ],
            'filter' => $this->filterPresenter->present(new Options(userId: $userId)),
            'marketplaces' => $this->marketplacesPresenter->present($userId),
            'paginator' => $paginator,
            'products' => $this->presentProducts(
                collect($pricesCalculated->calculatedPrices),
                $marketplace,
                new Options(userId: $userId),
            ),
        ];
    }

    private function presentProducts(Collection $products, Marketplace $marketplace, Options $options): array
    {
        return $products->transform(
            function (PriceCalculatedFromProduct $priceCalculatedFromProduct) use ($marketplace, $options) {
                $product = $priceCalculatedFromProduct->product;
                $price = $priceCalculatedFromProduct->calculatedPrice;

                return [
                    'sku' => $product->getSku(),
                    'name' => $product->getName(),
                    'price' => NumberTransformer::toMoney($price->get()),
                    'profit' => NumberTransformer::toMoney($price->getProfit()),
                    'margin' => NumberTransformer::toPercentage(
                        Percentage::fromPercentage($price->getMargin())
                    ),
                    'quantity' => $product->getQuantity(),
                    'variations' => []
                ];
            }
        )
        ->toArray();
    }
}
