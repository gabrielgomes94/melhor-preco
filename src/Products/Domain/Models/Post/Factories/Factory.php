<?php

namespace Src\Products\Domain\Models\Post\Factories;

use Illuminate\Container\Container;
use Src\Calculator\Domain\Models\Price\Price;
use Src\Calculator\Application\Services\CalculatePost;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Products\Domain\Models\Post\Identifiers\Identifiers as PostIdentifiers;
use Src\Products\Domain\Models\Post\Post as PostObject;
use Src\Products\Domain\Models\Product\Contracts\Post;
use Src\Products\Domain\Models\Product\Product;
use Src\Products\Domain\Models\Store\Factory as StoreFactory;

/**
 * Class Factory
 * @package Src\Products\Domain\Models\Post\Factories
 *
 * To Do: criar uma estrutura para validar e visualizar os atributos que precisam ser enviados no campo $data
 */
class Factory
{
    private Magalu $magaluFactory;
    private MercadoLivre $mercadoLivreFactory;

    public function __construct(
        Magalu $magaluFactory,
        MercadoLivre $mercadoLivreFactory
    ) {
        $this->magaluFactory = $magaluFactory;
        $this->mercadoLivreFactory = $mercadoLivreFactory;
    }

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

        $marketplaceRepository = app(MarketplaceRepository::class);
        $marketplace = $marketplaceRepository->getBySlug($data['store']);

        return new PostObject(
            identifiers: new PostIdentifiers($data['id'], $data['store_sku_id']),
            marketplace: $marketplace,
            price: $price
        );
    }

    public function updatePrice(Product $product, Post $post, Price $price): Post
    {
        $marketplaceSlug = $post->getMarketplace()->getSlug();
        if ($marketplaceSlug === 'magalu') {
            return $this->magaluFactory->updatePrice(
                $post,
                $price,
                $product->getCosts(),
                $product->getDimensions(),
                $product->getCategory()
            );
        }

        if ($marketplaceSlug === 'mercado-livre') {
            return $this->mercadoLivreFactory->updatePrice(
                $post,
                $price,
                $product->getCosts(),
                $product->getDimensions(),
                $product->getCategory()
            );
        }

        return new PostObject(
            identifiers: $post->getIdentifiers(),
            marketplace: $post->getMarketplace(),
            price: $price,
        );
    }
}
