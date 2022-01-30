<?php

namespace Src\Prices\Domain\UseCases\Contracts;

interface SynchronizePrices
{
    public function sync(): void;
}
