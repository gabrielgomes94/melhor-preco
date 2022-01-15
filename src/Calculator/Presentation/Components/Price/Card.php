<?php

namespace Src\Calculator\Presentation\Components\Price;

use Src\Calculator\Presentation\Components\PricesComponent;
use Src\Products\Domain\Models\Post\MagaluPost;
use Src\Products\Domain\Models\Post\MercadoLivrePost;

class Card extends PricesComponent
{
    /**
     * @inheritDoc
     */
    public function render()
    {
        if ($this->post instanceof MagaluPost) {
            return view('components.app.pricing.prices.price.magalu-card');
        }

        if ($this->post instanceof MercadoLivrePost) {
            return view('components.app.pricing.prices.price.mercado-livre-card');
        }

        return view('components.app.pricing.prices.price.card');
    }
}