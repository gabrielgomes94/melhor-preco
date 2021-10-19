<?php

namespace Src\Products\Domain\Post;

//use Src\Prices\Calculator\Domain\Price\V1\Price;
use Src\Prices\Calculator\Domain\Price\Price;
use Src\Prices\Calculator\Domain\Price\ProductData\ProductData;
use Src\Prices\Calculator\Domain\Services\CalculatePrice;
use Src\Products\Domain\Post\Identifiers\Identifiers as PostIdentifiers;
use Src\Products\Domain\Store\Factory as StoreFactory;

/**
 * To Do: mover essa classe pra camada de aplicação e fazer o make criar um objeto especializado quando for mercado livre.
 *  Criar interface para Factory e deixar ela na camada de domínio
 *
 * Class Factory
 * @package Src\Products\Domain\Post
 */
class Factory
{
    public static function make(array $data)
    {
        $service = app(CalculatePrice::class);

        $price = $service->calculate(
            new ProductData($data['costs'], $data['dimensions']),
            StoreFactory::make($data['store']),
            $data['value'],
            $data['commission'],
        );

        if ($data['store'] === 'mercado_livre') {
            return self::makeMercadoLivrePost($data, $price);
        }

        if ($data['store'] === 'magalu') {
            return self::makeMagaluPost($data, $price);
        }

        return new Post(
            identifiers: new PostIdentifiers($data['id'], $data['store_sku_id']),
            store: StoreFactory::make($data['store']),
            price: $price,
        );
    }

    public static function updatePrice(Post $post, Price $price)
    {
        $service = app(CalculatePrice::class);

        if ($post->getStore()->getSlug() === 'mercado_livre') {
            $post = new MercadoLivrePost(
                identifiers: $post->getIdentifiers(),
                store: $post->getStore(),
                price: $price,
            );

            $secondaryPrice = $service->calculate(
                new ProductData($data['costs'], $data['dimensions']),
                StoreFactory::make($data['store']),
                $data['value'],
                $data['commission'],
                ['ignoreFreight' => true]
            );

            $post->setSecondaryPrice($secondaryPrice);

            return $post;
        }

        if ($post->getStore()->getSlug() === 'magalu') {
            $post = new MagaluPost(
                identifiers: $post->getIdentifiers(),
                store: $post->getStore(),
                price: $price,
            );

            $secondaryPrice = $service->calculate(
                new ProductData($data['costs'], $data['dimensions']),
                StoreFactory::make($data['store']),
                $data['value'],
                $data['commission'],
                ['discountRate' => 0.05]
            );

            $post->setSecondaryPrice($secondaryPrice);

            return $post;
        }

    }

    private static function makeMagaluPost(array $data, Price $price): MagaluPost
    {
        $service = app(CalculatePrice::class);

        $post = new MagaluPost(
            identifiers: new PostIdentifiers($data['id'], $data['store_sku_id']),
            store: StoreFactory::make($data['store']),
            price: $price,
        );

        $secondaryPrice = $service->calculate(
            new ProductData($data['costs'], $data['dimensions']),
            StoreFactory::make($data['store']),
            $data['value'],
            $data['commission'],
            ['discountRate' => 0.05]
        );

        $post->setSecondaryPrice($secondaryPrice);

        return $post;
    }

    private static function makeMercadoLivrePost(array $data, Price $price): MercadoLivrePost
    {
        $service = app(CalculatePrice::class);

        $post = new MercadoLivrePost(
            new PostIdentifiers($data['id'], $data['store_sku_id']),
            StoreFactory::make($data['store']),
            price: $price
        );

        $secondaryPrice = $service->calculate(
            new ProductData($data['costs'], $data['dimensions']),
            StoreFactory::make($data['store']),
            $data['value'],
            $data['commission'],
            ['ignoreFreight' => true]
        );

        $post->setSecondaryPrice($secondaryPrice);

        return $post;
    }
}
