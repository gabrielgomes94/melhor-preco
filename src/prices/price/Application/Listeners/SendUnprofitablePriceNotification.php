<?php

namespace Src\Prices\Price\Application\Listeners;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Src\Notifications\Domain\Notifications\Prices\UnprofitablePrice as UnprofitablePriceNotification;
use Src\Prices\Price\Domain\Events\UnprofitablePrice;
use Src\Products\Domain\Store\Factory;

class SendUnprofitablePriceNotification implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  \Src\Prices\Price\Domain\Events\UnprofitablePrice  $event
     * @return void
     */
    public function handle(UnprofitablePrice $event)
    {
        $user = User::find(1);
        $price = $event->getPrice();
        $product = $price->product()->get()->first();
        $storeName = Factory::make($price->store)->getName();

        $user->notify(new UnprofitablePriceNotification([
            'priceId' => $price->id,
            'productId' => $price->getProductSku(),
            'productName' => $product->name,
            'profitValue' => $price->getProfit(),
            'priceValue' => $price->getValue(),
            'store' => $storeName,
            'storeSlug' => $price->store,
        ]));
    }
}
