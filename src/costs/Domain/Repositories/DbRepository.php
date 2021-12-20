<?php

namespace Src\Costs\Domain\Repositories;

use Illuminate\Support\Collection;

interface DbRepository
{
    public function listPurchaseInvoice(): Collection;
}
