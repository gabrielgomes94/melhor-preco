<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Models;

use Src\Marketplaces\Domain\Exceptions\InvalidCommissionTypeException;
use Src\Marketplaces\Domain\Models\CommissionType;
use Src\Marketplaces\Infrastructure\Laravel\Models\Commission\CategoryCommission;
use Src\Marketplaces\Infrastructure\Laravel\Models\Commission\UniqueCommission;

abstract class Commission implements CommissionType
{
    protected string $type;

    abstract public function getValues(): array;

    public static function fromArray(string $type, array $values = []): self
    {
        if ($type === self::CATEGORY_COMMISSION) {
            return new CategoryCommission($type, $values);
        }

        if ($type === self::UNIQUE_COMMISSION) {
            $value = array_shift($values);

            return new UniqueCommission($type, $value);
        }

        throw new InvalidCommissionTypeException($type);
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function hasCommissionByCategory(): bool
    {
        return $this->type === CommissionType::CATEGORY_COMMISSION;
    }

    public function hasUniqueCommission(): bool
    {
        return $this->type === CommissionType::UNIQUE_COMMISSION;
    }
}
