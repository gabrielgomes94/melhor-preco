<?php

namespace Barrigudinha\SaleOrder\ValueObjects\Address;

class NullAddress extends Address
{
    public function __construct()
    {
        parent::__construct('', '', '', '', '', '', null);
    }

    public function toArray(): array
    {
        return [];
    }
}
