<?php

namespace Src\Products\Domain\Post\Factories;

use Src\Math\Percentage;
use Src\Prices\Calculator\Domain\Services\Contracts\CalculatorOptions;
use Src\Prices\Calculator\Domain\Transformer\MoneyTransformer;
use Src\Prices\Calculator\Domain\Models\Price\Price;
use Src\Prices\Calculator\Domain\Models\Product\ProductData;
use Src\Prices\Calculator\Domain\Services\CalculatePost;
use Src\Prices\Calculator\Domain\Services\CalculatePrice;
use Src\Products\Domain\Post\Contracts\Factory as FactoryInterface;
use Src\Products\Domain\Post\Identifiers\Identifiers as PostIdentifiers;
use Src\Products\Domain\Post\MagaluPost;
use Src\Products\Domain\Post\Post;
use Src\Products\Domain\Product\Models\Data\Costs\Costs;
use Src\Products\Domain\Product\Models\Data\Dimensions\Dimensions;
use Src\Products\Domain\Store\Factory as StoreFactory;

class Magalu implements FactoryInterface
{
    private CalculatePrice $calculatePriceService;
    private CalculatePost $calculatePostService;

    public function __construct(CalculatePrice $calculatePriceService, CalculatePost $calculatePostService)
    {
        $this->calculatePriceService = $calculatePriceService;
        $this->calculatePostService = $calculatePostService;
    }

    public function make(array $data): Post
    {
        $price = $this->calculatePostService->calculate($data);

        $post = new MagaluPost(
            identifiers: new PostIdentifiers($data['id'], $data['store_sku_id']),
            store: StoreFactory::make($data['store']),
            price: $price,
        );

        $secondaryPrice = $this->calculatePostService->calculate($data, ['discountRate' => 0.05]);
        $post->setSecondaryPrice($secondaryPrice);

        return $post;
    }

    public function updatePrice(Post $post, Price $price, Costs $costs, Dimensions $dimensions): Post
    {
        $post = new MagaluPost(
            identifiers: $post->getIdentifiers(),
            store: $post->getStore(),
            price: $price,
        );
        $post->setSecondaryPrice($this->getSecondaryPrice($post, $costs, $dimensions));

        return $post;
    }

    private function getSecondaryPrice(Post $post, Costs $costs, Dimensions $dimensions): Price
    {
        return $this->calculatePriceService->calculate(
            productData: new ProductData($costs, $dimensions),
            store: $post->getStore(),
            value: MoneyTransformer::toFloat($post->getPrice()->get()),
            commission: Percentage::fromFraction($post->getPrice()->getCommission()->getCommissionRate()),
            options: [
                CalculatorOptions::DISCOUNT_RATE => Percentage::fromPercentage(5),
            ]
        );
    }
}
