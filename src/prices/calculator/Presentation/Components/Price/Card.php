<?php

namespace Src\Prices\Calculator\Presentation\Components\Price;

use Src\Prices\Calculator\Domain\PostPriced\MagaluPostPriced;
use Src\Prices\Calculator\Domain\PostPriced\MercadoLivrePostPriced;
use Src\Prices\Calculator\Presentation\Components\PricesComponent;

class Card extends PricesComponent
{
    /**
     * @inheritDoc
     */
    public function render()
    {
        if ($this->postPriced instanceof MagaluPostPriced) {
            return view('components.pricing.prices.price.magalu-card');
        }

        if ($this->postPriced instanceof MercadoLivrePostPriced) {
            return view('components.pricing.prices.price.mercado-livre-card');
        }

        return view('components.pricing.prices.price.card');
    }
}
