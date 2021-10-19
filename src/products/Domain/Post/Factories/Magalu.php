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

    public static function updatePrice(Post $post, Price $price, array $data): Post
    {
        $post = new MagaluPost(
            identifiers: $post->getIdentifiers(),
            store: $post->getStore(),
            price: $price,
        );
        $post->setSecondaryPrice(self::getSecondaryPrice($post, $data));

        return $post;
    }

    private static function getSecondaryPrice(Post $post, array $data): Price
    {
        $service = app(CalculatePrice::class);

        return $service->calculate(
            new ProductData($data['costs'], $data['dimensions']),
            $post->getStore(),
            MoneyTransformer::toFloat($post->getPrice()->get()),
            $post->getPrice()->getCommission()->getCommissionRate(),
            ['discountRate' => 0.05]
        );
    }
}
