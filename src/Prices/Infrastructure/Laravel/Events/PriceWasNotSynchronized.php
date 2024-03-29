<?php

namespace Src\Prices\Infrastructure\Laravel\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Src\Prices\Infrastructure\Laravel\Models\Price;

class PriceWasNotSynchronized
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

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
