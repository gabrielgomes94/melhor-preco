<?php

namespace Src\Marketplaces\Domain\Models\Commission;

use Src\Marketplaces\Domain\Models\Commission\Base\Commission;
use Src\Marketplaces\Domain\Models\Commission\Base\CommissionValuesCollection;
use Src\Math\Percentage;

class CategoryCommission extends Commission
{
    private CommissionValuesCollection $values;

    protected function __construct(string $type, CommissionValuesCollection $values)
    {
        $this->type = $type;
        $this->values = $values;
    }

    public function get(?string $categoryId = null): ?Percentage
    {
        foreach ($this->values->get() as $data) {
            if ($data->categoryId === $categoryId) {
                return $data->commission;
            }
        }

        return null;
    }

    public function getValues(): CommissionValuesCollection
    {
        return $this->values;
    }
}
