<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Models\Commission;

use Src\Marketplaces\Domain\DataTransfer\CommissionValue;
use Src\Marketplaces\Infrastructure\Laravel\Models\Commission;
use Src\Math\Percentage;

class UniqueCommission extends Commission
{
    private CommissionValue $value;

    public function __construct(string $type, ?CommissionValue $commission)
    {
        $this->type = $type;
        $this->value = $commission ?? new CommissionValue(Percentage::fromPercentage(0.0));
    }

    public function get(): Percentage
    {
        return $this->value->commission;
    }

    public function getValues(): array
    {
        return [$this->value];
    }
}
