<?php

namespace Src\Marketplaces\Domain\Models\Commission\Base;

use Src\Marketplaces\Domain\Exceptions\InvalidCommissionTypeException;
use Src\Marketplaces\Domain\Models\Commission\CategoryCommission;
use Src\Marketplaces\Domain\Models\Commission\UniqueCommission;

abstract class Commission
{
    public const CATEGORY_COMMISSION = 'categoryCommission';
    public const UNIQUE_COMMISSION = 'uniqueCommission';

    private static array $validTypes = [
        self::CATEGORY_COMMISSION,
        self::UNIQUE_COMMISSION,
    ];

    protected string $type;
    protected ?float $maximumValueCap = null;

    abstract public function getValues(): CommissionValuesCollection;

    /**
     * @throws InvalidCommissionTypeException
     */
    public static function build(
        string $type,
        ?CommissionValuesCollection $values = null,
        ?float $maximumValueCap = null
    ): self
    {
        if (!in_array($type, self::$validTypes)) {
            throw new InvalidCommissionTypeException($type);
        }

        if ($type === self::CATEGORY_COMMISSION) {
            $commission = new CategoryCommission($type, $values);
        } else {
            $commission = new UniqueCommission($type, $values);
        }

        $commission->maximumValueCap = $maximumValueCap;

        return $commission;
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

    public function hasMaximumValueCap(): bool
    {
        return (bool) $this->maximumValueCap;
    }

    public function getMaximumValueCap(): ?float
    {
        return $this->maximumValueCap;
    }
}
