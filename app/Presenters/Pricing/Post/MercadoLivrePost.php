<?php

namespace App\Presenters\Pricing\Post;

use App\Presenters\Pricing\Post\Contracts\HasSecondaryPrice;
use Barrigudinha\Pricing\Data\PostPriced\MercadoLivrePostPriced;

class MercadoLivrePost extends Post implements HasSecondaryPrice
{
    public function __construct(MercadoLivrePostPriced $postPriced)
    {
        parent::__construct($postPriced);
    }

    public function secondaryPrice(): array
    {
        return [
            'price' => $this->formatMoney($this->postPriced->secondaryPrice()->get()),
            'profit' => $this->formatMoney($this->postPriced->secondaryPrice()->profit()),
            'margin' => $this->postPriced->secondaryPrice()->margin(),
        ];
    }
}
