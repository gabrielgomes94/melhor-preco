<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Models\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use InvalidArgumentException;
use Src\Marketplaces\Domain\DataTransfer\CommissionValue;
use Src\Marketplaces\Domain\Models\Commission\Commission;
use Src\Marketplaces\Infrastructure\Laravel\Collections\CommissionValues;
use Src\Math\Percentage;

class CommissionCast implements CastsAttributes
{
    /**
     * @inheritDoc
     */
    public function get($model, string $key, $value, array $attributes)
    {
        $commission = json_decode($value, true);
        $commissionValues = collect($commission['values'] ?? [])
            ->map(
                function (array $value) {
                    $commission = $this->getCommission($value['commission']);

                    return new CommissionValue($commission, $value['categoryId']);
                }
            )
            ->toArray();

        return Commission::fromArray(
            $commission['type'],
            new CommissionValues($commissionValues)
        );
    }

    /**
     * @inheritDoc
     */
    public function set($model, string $key, $value, array $attributes)
    {
        if (!$value instanceof Commission) {
            throw new InvalidArgumentException('The given value is not a Commission instance.');
        }

        $commissionValues = collect($value->getValues())
            ->map(fn (CommissionValue $value) => $value->toArray());

        return [
            'commission' => [
                'type' => $value->getType(),
                'values' => $commissionValues,
            ]
        ];
    }

    /**
     * @param null|array|float $commission
     */
    private function getCommission(mixed $commission): ?Percentage
    {
        if (empty($commission)) {
            return Percentage::fromPercentage(0.0);
        }

        return Percentage::fromPercentage($commission);
    }
}
