<?php

namespace Src\Prices\Calculator\Application\Listeners;

use Src\Prices\Calculator\Domain\Services\CalculatePost;
use Src\Prices\Price\Application\Services\UpdatePrice;
use Src\Prices\Price\Domain\Models\Price;
use Src\Products\Domain\Product\Events\ProductCostsUpdated;
use Src\Products\Domain\Product\Models\Product;

class RecalculateProfit
{
    private CalculatePost $calculatePostService;
    private UpdatePrice $updatePrice;

    public function __construct(CalculatePost $calculatePostService, UpdatePrice $updatePrice)
    {
        $this->calculatePostService = $calculatePostService;
        $this->updatePrice = $updatePrice;
    }

    public function handle(ProductCostsUpdated $event)
    {
        $product = Product::find($event->getProductId());

        $this->recalculateProfit($product);
    }

    private function recalculateProfit(Product $product)
    {
        $posts = $product->data()->getPosts();

        foreach ($posts as $post) {
            $this->updatePrice->execute(
                model: Price::find($post->getId()),
                price: $this->calculatePostService->calculate($post)
            );
        }

        return $product;
    }
}
