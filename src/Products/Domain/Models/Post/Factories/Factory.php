<?php

namespace Src\Products\Domain\Models\Post\Factories;

use Src\Calculator\Domain\Models\Price\Price;
use Src\Calculator\Application\Services\CalculatePost;
use Src\Prices\Domain\Models\Price as PriceModel;
use Src\Products\Domain\Models\Post\Post as PostObject;
use Src\Products\Domain\Models\Product\Contracts\Post;
use Src\Products\Domain\Models\Product\Product;

class Factory
{
    private CalculatePost $calculatePostService;
    private Magalu $magaluFactory;
    private MercadoLivre $mercadoLivreFactory;

    public function __construct(
        Magalu $magaluFactory,
        MercadoLivre $mercadoLivreFactory,
        CalculatePost $calculatePostService
    ) {
        $this->magaluFactory = $magaluFactory;
        $this->mercadoLivreFactory = $mercadoLivreFactory;
        $this->calculatePostService = $calculatePostService;
    }

    public function make(Product $product, PriceModel $price): Post
    {
        $marketplace = $price->getMarketplace();
        $calculatedPrice = $this->calculatePostService->calculatePost($product, $price);

        $marketplaceSlug = $marketplace->getSlug();
        if ($marketplaceSlug === 'magalu') {
            return $this->magaluFactory->make($product, $price);
        } elseif ($marketplaceSlug === 'mercado-livre') {
            return $this->mercadoLivreFactory->make($product, $price);
        }

        return new PostObject(
            product: $product,
            priceModel: $price,
            calculatedPrice: $calculatedPrice
        );
    }

    public function updatePrice(Product $product, Post $post, Price $calculatedPrice): Post
    {
        $marketplace = $post->getMarketplace();
        $marketplaceSlug = $marketplace->getSlug();

        if ($marketplaceSlug === 'magalu') {
            return $this->magaluFactory->updatePrice(
                $post,
                $calculatedPrice
            );
        }

        if ($marketplaceSlug === 'mercado-livre') {
            return $this->mercadoLivreFactory->updatePrice(
                $post,
                $calculatedPrice
            );
        }

        return new PostObject(
            product: $product,
            priceModel: $calculatedPrice,
            calculatedPrice: $calculatedPrice
        );
    }
}
