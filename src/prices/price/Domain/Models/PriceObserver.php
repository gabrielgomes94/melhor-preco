<?php

namespace Src\Prices\Price\Domain\Models;

use Src\Prices\Price\Domain\Events\UnprofitablePrice;
use Src\Prices\Price\Domain\Models\Price;

class PriceObserver
{
    public function saved(Price $price)
    {
        if (!$price->isProfitable()) {
            UnprofitablePrice::dispatch($price);
        }
    }
}
