<?php

namespace Src\Costs\Domain\Services;

interface SyncPurchaseItems
{
    public function sync(string $userId): void;
}
