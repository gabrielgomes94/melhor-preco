<?php

namespace Src\Prices\Domain\Price\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Src\Prices\Domain\Price\Models\Price;

class UnprofitablePrice
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private Price $price;

    public function __construct(Price $price)
    {
        $this->price = $price;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }
}
