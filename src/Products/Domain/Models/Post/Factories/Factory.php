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

    public function make(PriceModel $price): Post
    {
        $marketplace = $price->getMarketplace();
        $calculatedPrice = $this->calculatePostService->calculatePost($price);

        $marketplaceSlug = $marketplace->getSlug();
        if ($marketplaceSlug === 'magalu') {
            return $this->magaluFactory->make($price);
        } elseif ($marketplaceSlug === 'mercado-livre') {
            return $this->mercadoLivreFactory->make($price);
        }

        return new PostObject(
            priceModel: $price,
            calculatedPrice: $calculatedPrice
        );
    }

    public function updatePrice(Post $post, Price $calculatedPrice): Post
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
            priceModel: $post->getPrice(),
            calculatedPrice: $calculatedPrice
        );
    }
}
