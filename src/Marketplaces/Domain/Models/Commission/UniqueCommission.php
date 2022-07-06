<?php

namespace Src\Marketplaces\Domain\Models\Commission;

use Src\Marketplaces\Domain\Models\Commission\Base\Commission;
use Src\Marketplaces\Domain\Models\Commission\Base\CommissionValue;
use Src\Marketplaces\Domain\Models\Commission\Base\CommissionValuesCollection;
use Src\Math\Percentage;

class UniqueCommission extends Commission
{
    private CommissionValue $value;

    protected function __construct(string $type, ?CommissionValuesCollection $values = null)
    {
        $this->type = $type;
        $this->value = $values?->first() ?? new CommissionValue(Percentage::fromPercentage(0));
    }

    public function get(): Percentage
    {
        return $this->value->commission;
    }

    public function getValues(): CommissionValuesCollection
    {
        return new CommissionValuesCollection([$this->value]);
    }
}
