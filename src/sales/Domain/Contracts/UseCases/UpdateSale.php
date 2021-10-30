<?php

namespace Src\Sales\Domain\Contracts\UseCases;

interface UpdateSale
{
    public function update(string $orderId);
}
