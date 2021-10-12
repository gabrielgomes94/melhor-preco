<?php

namespace Src\Prices\Presentation\Components\Prices\Price;

use Src\Prices\Domain\PostPriced\MagaluPostPriced;
use Src\Prices\Domain\PostPriced\MercadoLivrePostPriced;
use Src\Prices\Presentation\Components\Prices\PricesComponent;

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
