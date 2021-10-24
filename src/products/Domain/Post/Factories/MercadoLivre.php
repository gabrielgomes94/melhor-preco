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
use Src\Products\Domain\Product\Models\Data\Costs\Costs;
use Src\Products\Domain\Product\Models\Data\Dimensions\Dimensions;
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
        $secondaryPrice = self::getSecondaryPrice($post, $data['costs'], $data['dimensions']);
        $post->setSecondaryPrice($secondaryPrice);

        return $post;
    }

    public static function updatePrice(Post $post, Price $price, Costs $costs, Dimensions $dimensions): Post
    {
        $post = new MercadoLivrePost(
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
            options: ['ignoreFreight' => true]
        );
    }
}
