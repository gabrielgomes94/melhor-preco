<?php

namespace Src\Products\Domain\Store\Contracts;

interface Store
{
    public function getSlug(): string;

    public function getName(): string;

    public function getErpCode(): string;

    public function getDefaultCommission(): float;
}
