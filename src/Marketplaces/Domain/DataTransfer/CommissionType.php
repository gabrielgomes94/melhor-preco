<?php

namespace Src\Marketplaces\Domain\DataTransfer;

enum CommissionType: string
{
    case Category = 'categoryCommission';

    case Sku = 'skuCommission';

    case Unique = 'uniqueCommission';
}
