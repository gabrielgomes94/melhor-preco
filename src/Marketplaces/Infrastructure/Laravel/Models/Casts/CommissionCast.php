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
        $values = $this->transformValues($commission['values'] ?? []);

        return new Commission($commission['type'], $values ?? []);
    }

    /**
     * @inheritDoc
     */
    public function set($model, string $key, $value, array $attributes)
    {
        if (!$value instanceof Commission) {
            throw new InvalidArgumentException('The given value is not a Commission instance.');
        }

        return [
            'commission' => [
                'type' => $value->getType(),
                'values' => $value->getValues(),
            ]
        ];
    }

    private function transformValues(array $values): array
    {
        return collect($values)->map(
            fn (array $value) => new CommissionValue(
                Percentage::fromPercentage($value['commission']),
                $value['categoryId']
            )
        )->toArray();
    }
}
