<?php

namespace Src\Products\Domain\Post\Factories;

use Src\Prices\Calculator\Application\Transformer\MoneyTransformer;
use Src\Prices\Calculator\Domain\Price\Price;
use Src\Prices\Calculator\Domain\Price\ProductData\ProductData;
use Src\Prices\Calculator\Domain\Services\CalculatePost;
use Src\Prices\Calculator\Domain\Services\CalculatePrice;
use Src\Products\Domain\Post\Contracts\Factory as FactoryInterface;
use Src\Products\Domain\Post\Identifiers\Identifiers as PostIdentifiers;
use Src\Products\Domain\Post\MercadoLivrePost;
use Src\Products\Domain\Post\Post;
use Src\Products\Domain\Store\Factory as StoreFactory;

class MercadoLivre implements FactoryInterface
{
    public static function make(array $data): Post
    {
        $service = app(CalculatePost::class);

        $post = new MercadoLivrePost(
            new PostIdentifiers($data['id'], $data['store_sku_id']),
            StoreFactory::make($data['store']),
            price: $service->calculate($data)
        );
        $secondaryPrice = self::getSecondaryPrice($post, $data);
        $post->setSecondaryPrice($secondaryPrice);

        return $post;
    }

    public static function updatePrice(Post $post, Price $price, array $data): Post
    {
        $post = new MercadoLivrePost(
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
            productData: new ProductData($data['costs'], $data['dimensions']),
            store: $post->getStore(),
            value: MoneyTransformer::toFloat($post->getPrice()->get()),
            commission: $post->getPrice()->getCommission()->getCommissionRate(),
            options: ['ignoreFreight' => true]
        );
    }
}
