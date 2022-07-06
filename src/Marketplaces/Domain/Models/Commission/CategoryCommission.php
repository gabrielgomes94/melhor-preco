<?php

namespace Src\Marketplaces\Domain\Models\Commission;

use Src\Marketplaces\Domain\DataTransfer\Collections\CommissionValues;
use Src\Math\Percentage;

class CategoryCommission extends Commission
{
    protected CommissionValues $values;

    public function __construct(string $type, CommissionValues $values)
    {
        $this->type = $type;
        $this->values = $values;
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

    public function getValues(): CommissionValues
    {
        return $this->values;
    }
}
