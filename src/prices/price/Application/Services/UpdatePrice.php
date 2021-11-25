<?php

namespace Src\Prices\Price\Application\Services;

use Src\Prices\Calculator\Domain\Models\Price\Price as CalculatedPrice;
use Src\Prices\Calculator\Domain\Transformer\MoneyTransformer;
use Src\Prices\Price\Domain\Models\Price;

class UpdatePrice
{
    public function execute(Price $model, CalculatedPrice $price): bool
    {
        $model->value = MoneyTransformer::toFloat($price->get());
        $model->profit = MoneyTransformer::toFloat($price->getProfit());
        $model->commission = $price->getCommission()->getCommissionRate();

        return $model->save();
    }
}
