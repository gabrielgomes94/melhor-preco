<?php

namespace Src\Prices\Price\Application\Listeners;

use App\Models\User;
use App\Repositories\Store\Store;
use Illuminate\Contracts\Queue\ShouldQueue;
use Src\Notifications\Domain\Notifications\Prices\UnprofitablePrice as UnprofitablePriceNotification;
use Src\Prices\Price\Domain\Events\UnprofitablePrice;

class SendUnprofitablePriceNotification implements ShouldQueue
{
    private Store $storeRepository;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Store $storeRepository)
    {
        $this->storeRepository = $storeRepository;
    }

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
        $storeName = $this->storeRepository->name($price->store);

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
