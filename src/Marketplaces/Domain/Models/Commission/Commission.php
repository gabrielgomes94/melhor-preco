<?php

namespace Src\Marketplaces\Domain\Models\Commission;

use Src\Marketplaces\Domain\DataTransfer\Collections\CommissionValues;
use Src\Marketplaces\Domain\Exceptions\InvalidCommissionTypeException;

abstract class Commission
{
    public const CATEGORY_COMMISSION = 'categoryCommission';

    public const UNIQUE_COMMISSION = 'uniqueCommission';

    protected string $type;

    private static array $validTypes = [
        self::CATEGORY_COMMISSION,
        self::UNIQUE_COMMISSION,
    ];

    abstract public function getValues(): CommissionValues;

    /**
     * @throws InvalidCommissionTypeException
     */
    public static function fromArray(string $type, CommissionValues $values): self
    {
        if (!in_array($type, self::$validTypes)) {
            throw new InvalidCommissionTypeException($type);
        }

        if ($type === self::CATEGORY_COMMISSION) {
            return new CategoryCommission($type, $values);
        }

        return new UniqueCommission($type, $values);
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function hasCommissionByCategory(): bool
    {
        return $this->type === self::CATEGORY_COMMISSION;
    }

    public function hasUniqueCommission(): bool
    {
        return $this->type === self::UNIQUE_COMMISSION;
    }
}
