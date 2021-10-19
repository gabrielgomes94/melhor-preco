<?php

namespace Src\Products\Domain\Post\Factories;

use Src\Prices\Calculator\Domain\Price\Price;
use Src\Prices\Calculator\Domain\Services\CalculatePost;
use Src\Products\Domain\Post\Identifiers\Identifiers as PostIdentifiers;
use Src\Products\Domain\Post\Post;
use Src\Products\Domain\Store\Factory as StoreFactory;

class Factory
{
    private static array $mapper = [
        'magalu' => Magalu::class,
        'mercado_livre' => MercadoLivre::class,
    ];

    public static function make(array $data): Post
    {
        if (in_array($data['store'], array_keys(self::$mapper))) {
            $class = self::$mapper[$data['store']];

            return $class::make($data);
        }

        $service = app(CalculatePost::class);

        $price = $service->calculate($data);

        return new Post(
            identifiers: new PostIdentifiers($data['id'], $data['store_sku_id']),
            store: StoreFactory::make($data['store']),
            price: $price,
        );
    }

    public static function updatePrice(Post $post, Price $price, array $data): Post
    {
        $store = $post->getStore()->getSlug();
        if (in_array($store, array_keys(self::$mapper))) {
            $class = self::$mapper[$store];

            return $class::updatePrice($post, $price, $data);
        }

        return new Post(
            identifiers: $post->getIdentifiers(),
            store: $post->getStore(),
            price: $price,
        );
    }
}
