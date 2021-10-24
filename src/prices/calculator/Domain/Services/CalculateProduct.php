<?php

namespace Src\Prices\Calculator\Domain\Services;

use Src\Prices\Calculator\Application\Transformer\MoneyTransformer;
use Src\Prices\Price\Domain\Models\Price;
use Src\Products\Domain\Product\Models\Product;

class CalculateProduct
{
    private CalculatePost $calculatePriceService;

    public function __construct(CalculatePost $calculatePriceService)
    {
        $this->calculatePriceService = $calculatePriceService;
    }

    public function recalculateProfit(Product $product): Product
    {
        $posts = $product->data()->getPosts();

        foreach ($posts as $post) {
            $priceModel = Price::find($post->getId());
            $price = $this->calculatePriceService->calculate($post);

            $priceModel->value = MoneyTransformer::toFloat($price->get());
            $priceModel->profit = MoneyTransformer::toFloat($price->getProfit());
            $priceModel->commission = $price->getCommission()->getCommissionRate();

            $priceModel->save();

        }

        return $product;
    }

//    public function recalculateProfitInStore(Product $product, string $storeSlug): Product
//    {
//
//    }
}
