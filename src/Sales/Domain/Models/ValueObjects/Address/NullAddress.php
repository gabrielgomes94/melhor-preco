<?php

namespace Src\Sales\Domain\Models\ValueObjects\Address;

use Src\Sales\Domain\Models\ValueObjects\Address\Address;

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
