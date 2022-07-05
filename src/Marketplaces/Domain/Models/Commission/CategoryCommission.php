<?php

namespace Src\Marketplaces\Domain\Models\Commission;

use Src\Marketplaces\Domain\DataTransfer\Collections\CommissionValues;
use Src\Marketplaces\Domain\DataTransfer\CommissionValue;
use Src\Math\Percentage;

class CategoryCommission extends Commission
{
    /**
     * @var CommissionValue[] $values
     */
    protected array $values;

    public function __construct(string $type, CommissionValues $values)
    {
        $this->type = $type;
        $this->values = $values
            ->map(fn (CommissionValue $categoryCommission) => $categoryCommission)
            ->toArray();
    }

    public function get(?string $categoryId = null): ?Percentage
    {
        foreach ($this->values as $data) {
            if ($data->categoryId === $categoryId) {
                return $data->commission;
            }
        }

        return null;
    }

    public function getValues(): array
    {
        return $this->values;
    }
}
