<?php

namespace Src\Products\Domain\Models\Post\Factories;

use Src\Math\Percentage;
use Src\Prices\Calculator\Domain\Transformer\MoneyTransformer;
use Src\Prices\Calculator\Domain\Models\Price\Price;
use Src\Prices\Calculator\Domain\Models\Product\ProductData;
use Src\Prices\Calculator\Domain\Services\CalculatePost;
use Src\Prices\Calculator\Domain\Services\CalculatePrice;
use Src\Products\Domain\Models\Post\Contracts\Factory as FactoryInterface;
use Src\Products\Domain\Models\Post\Identifiers\Identifiers as PostIdentifiers;
use Src\Products\Domain\Models\Post\MercadoLivrePost;
use Src\Products\Domain\Models\Post\Post;
use Src\Products\Domain\Models\Product\Data\Costs\Costs;
use Src\Products\Domain\Models\Product\Data\Dimensions\Dimensions;
use Src\Products\Domain\Models\Store\Factory as StoreFactory;

class MercadoLivre implements FactoryInterface
{
    private CalculatePrice $calculatePriceService;
    private CalculatePost $calculatePostService;

    public function __construct(CalculatePrice $calculatePriceService, CalculatePost $calculatePostService)
    {
        $this->calculatePriceService = $calculatePriceService;
        $this->calculatePostService = $calculatePostService;
    }

    public function make(array $data): Post
    {
        $post = new MercadoLivrePost(
            new PostIdentifiers($data['id'], $data['store_sku_id']),
            StoreFactory::make($data['store']),
            price: $this->calculatePostService->calculate($data)
        );
        $secondaryPrice = self::getSecondaryPrice($post, $data['costs'], $data['dimensions']);
        $post->setSecondaryPrice($secondaryPrice);

        return $post;
    }

    public function updatePrice(Post $post, Price $price, Costs $costs, Dimensions $dimensions): Post
    {
        $post = new MercadoLivrePost(
            identifiers: $post->getIdentifiers(),
            store: $post->getStore(),
            price: $price,
        );
        $post->setSecondaryPrice(self::getSecondaryPrice($post, $costs, $dimensions));

        return $post;
    }

    private function getSecondaryPrice(Post $post, Costs $costs, Dimensions $dimensions): Price
    {
        return $this->calculatePriceService->calculate(
            productData: new ProductData($costs, $dimensions),
            store: $post->getStore(),
            value: MoneyTransformer::toFloat($post->getPrice()->get()),
            commission: Percentage::fromFraction($post->getPrice()->getCommission()->getCommissionRate()),
            options: ['ignoreFreight' => true]
        );
    }
}
