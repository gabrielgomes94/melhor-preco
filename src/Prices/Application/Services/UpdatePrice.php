<?php

namespace Src\Prices\Application\Services;

use Src\Calculator\Domain\Models\Price\Contracts\Price as CalculatedPrice;
use Src\Math\MoneyTransformer;
use Src\Prices\Domain\Models\Price;

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
