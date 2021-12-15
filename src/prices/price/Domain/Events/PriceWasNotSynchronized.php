<?php

namespace Src\Prices\Price\Domain\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Src\Prices\Price\Domain\Models\Price;

class PriceWasNotSynchronized
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
