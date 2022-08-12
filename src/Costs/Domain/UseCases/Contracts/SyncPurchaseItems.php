<?php

namespace Src\Costs\Domain\UseCases\Contracts;

interface SyncPurchaseItems
{
    public function sync(string $userId): void;
}
