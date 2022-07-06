<?php

namespace Src\Marketplaces\Domain\Models\Commission;

use Src\Marketplaces\Domain\Models\Commission\Base\Commission;
use Src\Marketplaces\Domain\Models\Commission\Base\CommissionValuesCollection;
use Src\Math\Percentage;

class UniqueCommission extends Commission
{
    protected CommissionValuesCollection $values;

    public function __construct(string $type, CommissionValuesCollection $values)
    {
        $this->type = $type;
        $this->values = $values;
    }

    public function get(): Percentage
    {
        return $this->values->first()->commission;
    }

    public function getValues(): CommissionValuesCollection
    {
        return $this->values;
    }
}
