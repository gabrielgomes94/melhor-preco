<?php

namespace Src\Prices\Domain\Models;

use Src\Prices\Domain\Events\UnprofitablePrice;
use Src\Prices\Domain\Models\Price;

class PriceObserver
{
    public function saved(Price $price)
    {
        if (!$price->isProfitable()) {
            UnprofitablePrice::dispatch($price);
        }
    }
}
