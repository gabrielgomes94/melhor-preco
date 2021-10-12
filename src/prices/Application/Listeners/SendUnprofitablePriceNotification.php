<?php

namespace Src\Prices\Application\Listeners;

use App\Models\User;
use App\Repositories\Store\Store;
use Illuminate\Contracts\Queue\ShouldQueue;
use Src\Notifications\Domain\Notifications\Prices\UnprofitablePrice as UnprofitablePriceNotification;
use Src\Prices\Domain\Price\Events\UnprofitablePrice;

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
     * @param  UnprofitablePrice  $event
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
            'link' => route('pricing.products.showByStore', [
                'store' => $price->store,
                'product_id' => $price->getProductSku(),
            ]),
        ]));
    }
}
