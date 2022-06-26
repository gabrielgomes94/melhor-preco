<?php

namespace Src\Prices\Infrastructure\Laravel\Models;

use Src\Prices\Domain\Events\UnprofitablePrice;

class PriceObserver
{
    public function saved(Price $price)
    {
        if (!$price->isProfitable()) {
            UnprofitablePrice::dispatch($price);
        }
    }
}
