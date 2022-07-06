<?php

namespace Src\Marketplaces\Domain\Models\Commission;

use Src\Marketplaces\Domain\Models\Commission\Base\Commission;
use Src\Marketplaces\Domain\Models\Commission\Base\CommissionValue;
use Src\Marketplaces\Domain\Models\Commission\Base\CommissionValuesCollection;
use Src\Math\Percentage;

class CategoryCommission extends Commission
{
    private CommissionValuesCollection $values;

    protected function __construct(string $type, ?CommissionValuesCollection $values = null)
    {
        $this->type = $type;
        $this->values = $values ?? new CommissionValuesCollection([
            new CommissionValue(Percentage::fromPercentage(0))
        ]);
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
