<?php

namespace Barrigudinha\Pricing\Data\PostPriced\Contracts;

use Barrigudinha\Pricing\Data\Price;

interface HasSecondaryPrice
{
    public function secondaryPrice(): Price;
}
