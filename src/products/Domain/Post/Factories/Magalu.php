<?php

namespace Src\Products\Domain\Post\Factories;

use Src\Prices\Calculator\Application\Transformer\MoneyTransformer;
use Src\Prices\Calculator\Domain\Price\Price;
use Src\Prices\Calculator\Domain\Price\ProductData\ProductData;
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
    public static function make(array $data): Post
    {
        $service = app(CalculatePost::class);

        $price = $service->calculate($data);
        $post = new MagaluPost(
            identifiers: new PostIdentifiers($data['id'], $data['store_sku_id']),
            store: StoreFactory::make($data['store']),
            price: $price,
        );
        $secondaryPrice = $service->calculate($data, ['discountRate' => 0.05]);
        $post->setSecondaryPrice($secondaryPrice);

        return $post;
    }

    public static function updatePrice(Post $post, Price $price, Costs $costs, Dimensions $dimensions): Post
    {
        $post = new MagaluPost(
            identifiers: $post->getIdentifiers(),
            store: $post->getStore(),
            price: $price,
        );
        $post->setSecondaryPrice(self::getSecondaryPrice($post, $costs, $dimensions));

        return $post;
    }

    private static function getSecondaryPrice(Post $post, Costs $costs, Dimensions $dimensions): Price
    {
        $service = app(CalculatePrice::class);

        return $service->calculate(
            productData: new ProductData($costs, $dimensions),
            store: $post->getStore(),
            value: MoneyTransformer::toFloat($post->getPrice()->get()),
            commission: $post->getPrice()->getCommission()->getCommissionRate(),
            options: ['discountRate' => 0.05]
        );
    }
}
