<?php

namespace Src\Prices\Domain\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Src\Prices\Domain\Models\Price;

class UnprofitablePrice
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

    public function toArray(): array
    {
        $price = $this->getPrice();
        $product = $price->product()->first();

        return [
            'priceId' => $price->id,
            'productId' => $price->getProductSku(),
            'productName' => $product->name,
            'profitValue' => $price->getProfit(),
            'priceValue' => $price->getValue(),
            'store' => $price->store,
            'storeSlug' => $price->store,
        ];
    }
}
