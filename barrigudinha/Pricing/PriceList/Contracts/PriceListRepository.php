<?php

namespace Barrigudinha\Pricing\PriceList\Contracts;

use Barrigudinha\Pricing\PriceList\PriceList;

interface PriceListRepository
{
    public function get(string $id): PriceList;
}
