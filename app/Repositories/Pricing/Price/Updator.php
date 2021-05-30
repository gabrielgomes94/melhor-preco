<?php

namespace App\Repositories\Pricing\Price;

use App\Models\Price;

class Updator
{
    public function update(string $priceId, array $data)
    {
        if (!$price = Price::find($priceId)) {
            return false;
        }

        $price->value = $data['value'];
        $price->profit = $data['profit'];

        return $price->save();
    }
}
