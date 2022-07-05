<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Models;

use Exception;
use Src\Marketplaces\Domain\DataTransfer\CommissionValue;
use Src\Marketplaces\Domain\Exceptions\InvalidCommissionTypeException;
use Src\Marketplaces\Domain\Models\CommissionType;
use Src\Math\Percentage;

class Commission implements CommissionType
{
    private string $type;
    private array $values;

    private array $validTypes = [
        self::CATEGORY_COMMISSION,
        self::UNIQUE_COMMISSION,
    ];

    /**
     * @param CommissionValue[] $values
     * @throws \Exception
     */
    public function __construct(string $type, array $values = [])
    {
        if (!in_array($type, $this->validTypes)) {
            throw new InvalidCommissionTypeException($type);
        }

        $this->type = $type;

        if ($this->hasCommissionByCategory()) {
            $this->setCommissionsByCategory($values);
        }

        if ($this->hasUniqueCommission()) {
            $this->setCommissionByUniqueValue(array_shift($values));
        }
    }


    public function getType(): string
    {
        return $this->type;
    }

    public function getOnlyValues(): array
    {
        $commissions = $this->values;

        foreach ($commissions as $data) {
            $commissionList[] = $data['commission'] ?? null;
        }

        return array_unique($commissionList ?? []);
    }

    public function getValues(): array
    {
        return $this->values;
    }

    public function hasCommissionByCategory(): bool
    {
        return $this->type === CommissionType::CATEGORY_COMMISSION;
    }

    public function hasUniqueCommission(): bool
    {
        return $this->type === CommissionType::UNIQUE_COMMISSION;
    }

    public function getCommissionByCategory(?string $categoryId = null): ?Percentage
    {
        if (!$this->hasCommissionByCategory()) {
            throw new Exception('Marketplace não possui comissões por categorias.');
        }

        $commissions = $this->values;

        foreach ($commissions as $data) {
            if ($data['categoryId'] == $categoryId) {
                return Percentage::fromPercentage($data['commission']);
            }
        }

        return null;
    }

    public function getUniqueCommission(): ?Percentage
    {
        if (!$this->hasUniqueCommission()) {
            throw new Exception('Marketplace possui varias commissões');
        }

        $commissions = $this->values;
        $data = array_shift($commissions);

        if (empty($data['commission'])) {
            return null;
        }

        return Percentage::fromPercentage($data['commission']);
    }

    public function setCommissionsByCategory(array $commissions): void
    {
        $commissions = collect($commissions);

        $this->values = $commissions->map(
            fn (CommissionValue $categoryCommission) => $categoryCommission->toArray()
        )->toArray();
    }

    public function setCommissionByUniqueValue(?CommissionValue $commission): void
    {
        if (!$commission) {
            $this->values = [];

            return;
        }

        $this->values = [$commission->toArray()];
    }
}
