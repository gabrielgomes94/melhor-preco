<?php

namespace Src\Products\Domain\Contracts\Store;

interface Store
{
    public function slug(): string;

    public function name(): string;

    public function erpCode(): string;

    public function defaultCommission(): float;
}
