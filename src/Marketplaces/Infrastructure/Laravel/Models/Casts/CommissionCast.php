<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Models\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use InvalidArgumentException;
use Src\Marketplaces\Domain\DataTransfer\CommissionValue;
use Src\Marketplaces\Infrastructure\Laravel\Models\Commission;
use Src\Math\Percentage;

class CommissionCast implements CastsAttributes
{
    /**
     * @inheritDoc
     * @throws \Exception
     */
    public function get($model, string $key, $value, array $attributes)
    {
        $commission = json_decode($value, true);
        $values = collect($commission['values'] ?? [])
            ->map(
                fn (array $value) => new CommissionValue(
                    $this->getCommission($value['commission']),
                    $value['categoryId']
                )
            )
            ->toArray();

        return Commission::fromArray($commission['type'], $values ?? []);
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
