<?php

namespace Src\Costs\Domain\Repositories;

interface ErpRepository
{
    public function listPurchaseInvoice(string $erpToken);
}
