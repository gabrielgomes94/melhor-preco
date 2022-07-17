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

        // @todo: salvar os dados de margin no banco para evitar essa lógica de negócio aqui na apresentação
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
}
