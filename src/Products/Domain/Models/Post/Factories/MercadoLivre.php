<?php

namespace Src\Products\Domain\Models\Post\Factories;

use Src\Calculator\Domain\Models\Price\Price;
use Src\Calculator\Application\Services\CalculatePost;
use Src\Prices\Domain\Models\Price as PriceModel;
use Src\Products\Domain\Models\Post\Contracts\Factory as FactoryInterface;
use Src\Products\Domain\Models\Post\MercadoLivrePost;
use Src\Products\Domain\Models\Post\Post;

class MercadoLivre implements FactoryInterface
{
    private CalculatePost $calculatePostService;

    public function __construct(CalculatePost $calculatePostService) {
        $this->calculatePostService = $calculatePostService;
    }

    public function make(PriceModel $priceModel): Post
    {
        return new MercadoLivrePost(
            priceModel: $priceModel,
            calculatedPrice: $this->calculatePostService->calculatePost($priceModel)
        );
    }

    public function updatePrice(Post $post, Price $calculatedPrice): Post
    {
        return new MercadoLivrePost(
            priceModel: $post->getPriceModel(),
            calculatedPrice: $calculatedPrice
        );
    }
}
