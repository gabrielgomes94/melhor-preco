<?php

namespace Src\Products\Domain\Post\Factories;

use Src\Prices\Calculator\Domain\Price\Price;
use Src\Prices\Calculator\Domain\Services\CalculatePost;
use Src\Products\Domain\Post\Identifiers\Identifiers as PostIdentifiers;
use Src\Products\Domain\Post\Post as PostObject;
use Src\Products\Domain\Product\Contracts\Models\Post;
use Src\Products\Domain\Product\Models\Data\ProductData;
use Src\Products\Domain\Store\Factory as StoreFactory;

/**
 * Class Factory
 * @package Src\Products\Domain\Post\Factories
 *
 * To Do: criar uma estrutura para validar e visualizar os atributos que precisam ser enviados no campo $data
 */
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

        return new PostObject(
            identifiers: new PostIdentifiers($data['id'], $data['store_sku_id']),
            store: StoreFactory::make($data['store']),
            price: $price,
        );
    }

    public static function updatePrice(ProductData $product, Post $post, Price $price): Post
    {
        $store = $post->getStore()->getSlug();
        if (in_array($store, array_keys(self::$mapper))) {
            $class = self::$mapper[$store];

            return $class::updatePrice($post, $price, $product->getCosts(), $product->getDimensions());
        }

        return new PostObject(
            identifiers: $post->getIdentifiers(),
            store: $post->getStore(),
            price: $price,
        );
    }
}
