<?php

namespace Src\Sales\Domain\Contracts\UseCases;

interface ShowSale
{
    public function show(string $orderId);
}
