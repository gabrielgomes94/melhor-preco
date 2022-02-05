<?php

namespace Src\Products\Domain\Models\Post\Factories;

use Src\Calculator\Domain\Models\Price\Price;
use Src\Calculator\Application\Services\CalculatePost;
use Src\Calculator\Application\Services\CalculatePrice;
use Src\Prices\Domain\Models\Price as PriceModel;
use Src\Products\Domain\Models\Post\Contracts\Factory as FactoryInterface;
use Src\Products\Domain\Models\Post\MercadoLivrePost;
use Src\Products\Domain\Models\Post\Post;
use Src\Products\Domain\Models\Product\Product;

class MercadoLivre implements FactoryInterface
{
    use WithSecondaryPriceFactory;

    private CalculatePrice $calculatePriceService;
    private CalculatePost $calculatePostService;

    public function __construct(
        CalculatePrice $calculatePriceService,
        CalculatePost $calculatePostService,
    ) {
        $this->calculatePriceService = $calculatePriceService;
        $this->calculatePostService = $calculatePostService;
    }

    public function make(Product $product, PriceModel $priceModel): Post
    {
        $post = new MercadoLivrePost(
            product: $product,
            priceModel: $priceModel,
            calculatedPrice: $this->calculatePostService->calculatePost($product, $priceModel)
        );

        $post->setSecondaryPrice(
            $this->getSecondaryPriceCalculated($post)
        );

        return $post;
    }

    public function updatePrice(Post $post, Price $calculatedPrice): Post
    {
        $post = new MercadoLivrePost(
            product: $post->getProduct(),
            priceModel: $post->getPriceModel(),
            calculatedPrice: $calculatedPrice
        );

        $post->setSecondaryPrice(
            $this->getSecondaryPriceCalculated(
                $post,
                ['ignoreFreight' => true]
            )
        );

        return $post;
    }
}
