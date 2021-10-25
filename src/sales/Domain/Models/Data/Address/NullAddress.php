<?php

namespace Src\Sales\Domain\Models\Data\Address;

use Src\Sales\Domain\Models\Data\Address\Address;

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
