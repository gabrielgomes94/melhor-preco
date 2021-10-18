<?php

namespace Src\Products\Domain\Post;

use Src\Prices\Calculator\Domain\Price\Price;
use Src\Products\Domain\Post\Contracts\HasSecondaryPrice;
use Src\Products\Domain\Post\Identifiers\Identifiers;
use Src\Products\Domain\Store\Store;

class MercadoLivrePost extends Post implements HasSecondaryPrice
{
    private Price $secondaryPrice;

//    public function __construct(Identifiers $identifiers, Price $price, Store $store)
//    {
//        parent::__construct($identifiers, $price, $store);
//
////        $this->priceWithoutFreight = new Price(
////            product: $product,
////            value: $price->get(),
////            store: \Barrigudinha\Store\Store::MERCADO_LIVRE,
////            commission: $commission,
////            options: [
////                'ignoreFreight' => true,
////            ]
////        );
//    }

    public function getSecondaryPrice(): float
    {
        // TODO: Implement getSecondaryPrice() method.
    }

    public function getSecondaryProfit(): float
    {
        // TODO: Implement getSecondaryProfit() method.
    }

    public function setSecondaryPrice(Price $secondaryPrice): void
    {
        $this->secondaryPrice = $secondaryPrice;
    }
}
