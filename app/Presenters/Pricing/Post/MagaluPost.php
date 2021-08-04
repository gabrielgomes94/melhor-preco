<?php

namespace App\Presenters\Pricing\Post;

use App\Presenters\Pricing\Post\Contracts\HasSecondaryPrice;
use Barrigudinha\Pricing\Data\PostPriced\MagaluPostPriced;

class MagaluPost extends Post implements HasSecondaryPrice
{
//    public string $discountedPrice;
//    public string $discountedProfit;
//    public string $discountedMargin;

    public function __construct(MagaluPostPriced $postPriced)
    {
        parent::__construct($postPriced);

//        $this->discountedPrice = $this->formatMoney($postPriced->discountedPrice()->get());
//        $this->discountedProfit = $this->formatMoney($postPriced->discountedPrice()->profit());
//        $this->discountedMargin = $postPriced->discountedPrice()->margin();
    }

    public function secondaryPrice(): array
    {
        return [
            'price' => $this->formatMoney($this->postPriced->discountedPrice()->get()),
            'profit' => $this->formatMoney($this->postPriced->discountedPrice()->profit()),
            'margin' => $this->postPriced->discountedPrice()->margin(),
        ];
    }
}
