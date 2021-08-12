<?php

namespace Barrigudinha\Pricing\Data\PostPriced\Contracts;

use Barrigudinha\Pricing\Price\Price;

interface HasSecondaryPrice
{
    public function secondaryPrice(): Price;
}
