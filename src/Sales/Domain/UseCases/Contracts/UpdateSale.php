<?php

namespace Src\Sales\Domain\UseCases\Contracts;

interface UpdateSale
{
    public function update(string $orderId);
}
