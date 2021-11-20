<?php

namespace Src\Sales\Domain\UseCases\Contracts;

interface ShowSale
{
    public function show(string $orderId);
}
