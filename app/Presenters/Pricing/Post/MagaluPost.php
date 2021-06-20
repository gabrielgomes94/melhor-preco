<?php

namespace App\Presenters\Pricing\Post;

use Barrigudinha\Pricing\Data\PostPriced\MagaluPostPriced;

class MagaluPost extends Post
{
    public string $discountedPrice;
    public string $discountedProfit;
    public string $discountedMargin;

    public function __construct(MagaluPostPriced $postPriced)
    {
        parent::__construct($postPriced);

        $this->discountedPrice = $this->formatMoney($postPriced->discountedPrice()->get());
        $this->discountedProfit = $this->formatMoney($postPriced->discountedPrice()->profit());
        $this->discountedMargin = $postPriced->discountedPrice()->margin();
    }
}
