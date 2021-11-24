<?php

namespace Src\Products\Domain\Post\Factories;

use Illuminate\Container\Container;
use Src\Prices\Calculator\Domain\Models\Price\Price;
use Src\Prices\Calculator\Domain\Services\CalculatePost;
use Src\Products\Domain\Post\Contracts\Factory as FactoryInterface;
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
        $applicationContainer = Container::getInstance();

        if (in_array($data['store'], array_keys(self::$mapper))) {
            $class = self::$mapper[$data['store']];
            $factory = $applicationContainer->make($class);

            return $factory->make($data);
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
        $applicationContainer = Container::getInstance();

        if (in_array($store, array_keys(self::$mapper))) {
            $class = self::$mapper[$store];
            $factory = $applicationContainer->make($class);

            return $factory->updatePrice($post, $price, $product->getCosts(), $product->getDimensions());
        }

        return new PostObject(
            identifiers: $post->getIdentifiers(),
            store: $post->getStore(),
            price: $price,
        );
    }
}
