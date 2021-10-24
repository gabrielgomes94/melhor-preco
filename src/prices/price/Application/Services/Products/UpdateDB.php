<?php

namespace Src\Prices\Price\Application\Services\Products;

use Src\Prices\Calculator\Application\Transformer\MoneyTransformer;
use Src\Prices\Price\Domain\Models\Price;
use Src\Prices\Price\Infrastructure\Repositories\Repository;
use Src\Prices\Price\Domain\Contracts\Services\UpdateDB as UpdateDBInterface;
use Src\Products\Domain\Product\Contracts\Models\Post;

class UpdateDB implements UpdateDBInterface
{
    private Repository $priceRepository;

    public function __construct(Repository $priceRepository)
    {
        $this->priceRepository = $priceRepository;
    }

    public function execute(Post $post): bool
    {
        $priceModel = Price::find($post->getId());

        if (!$priceModel) {
            return false;
        }

        $price = $post->getPrice();
        $priceModel->value = MoneyTransformer::toFloat($price->get());
        $priceModel->profit = MoneyTransformer::toFloat($price->getProfit());
        $priceModel->commission = $price->getCommission()->getCommissionRate();

        return $priceModel->save();
    }
}
