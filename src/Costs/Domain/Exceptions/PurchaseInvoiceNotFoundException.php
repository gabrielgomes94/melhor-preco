<?php

namespace Src\Costs\Domain\Exceptions;

class PurchaseInvoiceNotFoundException extends \Exception
{
    public function __construct(string $purchaseInvoiceUuid)
    {
        parent::__construct("Nota fiscal {$purchaseInvoiceUuid} não foi encontrada.");
    }
}
