<?php

namespace Src\Sales\Domain\Models\Data\Invoice;

use Carbon\Carbon;
use Src\Sales\Domain\Models\Data\Invoice\Invoice;

class NullInvoice extends Invoice
{
    public function __construct()
    {
        parent::__construct('', '', new Carbon(), '', 0.0, '');
    }

    public function toArray(): array
    {
        return [];
    }
}
