<?php

namespace Src\Costs\Domain\Models;

interface Tax
{
    public const COFINS = 'cofins';

    public const ICMS = 'icms';

    public const IPI = 'ipi';

    public const PIS = 'pis';

    public const TOTAL_TAXES =  'totalTaxes';
}
