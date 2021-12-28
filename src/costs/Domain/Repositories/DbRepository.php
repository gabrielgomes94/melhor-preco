<?php

namespace Src\Costs\Domain\Repositories;

use Illuminate\Support\Collection;
use Src\Costs\Domain\Models\PurchaseInvoice;

interface DbRepository
{
    public function getPurchaseInvoice(string $uuid): ?PurchaseInvoice;

    public function listPurchaseInvoice(): Collection;
}
