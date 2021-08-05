<?php

namespace App\Presenters\Pricing\Post\Contracts;

interface HasSecondaryPrice
{
    public function secondaryPrice(): array;
}
