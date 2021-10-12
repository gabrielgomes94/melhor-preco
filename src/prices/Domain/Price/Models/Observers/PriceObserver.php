<?php

namespace Src\Prices\Domain\Price\Models\Observers;

use Src\Prices\Domain\Price\Events\UnprofitablePrice;
use Src\Prices\Domain\Price\Models\Price;

class PriceObserver
{
    public function saved(Price $price)
    {
        if (!$price->isProfitable()) {
            UnprofitablePrice::dispatch($price);
        }
    }
}
