<?php

namespace Src\Notifications\Domain\Rules;

use Src\Notifications\Domain\Contracts\Rules\Rule;
use Src\Prices\Infrastructure\Laravel\Models\Price;

class UnprofitablePrice implements Rule
{
    public function isSolved(array $data): bool
    {
        $priceId = $data['content']['priceId'];
        $price = Price::find($priceId);

        return $price->isProfitable();
    }
}
