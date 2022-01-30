<?php

namespace Src\Marketplaces\Domain\Models\Contracts;

interface CommissionType
{
    public const CATEGORY_COMMISSION = 'categoryCommission';

    public const SKU_COMMISSION = 'skuCommission';

    public const UNIQUE_COMMISSION = 'uniqueCommission';
}
