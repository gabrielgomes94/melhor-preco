<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Models\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use InvalidArgumentException;
use Src\Marketplaces\Domain\Models\Commission\Base\Commission;
use Src\Marketplaces\Domain\Models\Commission\Base\CommissionValue;
use Src\Marketplaces\Domain\Models\Commission\Base\CommissionValuesCollection;
use Src\Math\Percentage;

class CommissionCast implements CastsAttributes
{
    /**
     * @inheritDoc
     */
    public function get($model, string $key, $value, array $attributes)
    {
        $commission = json_decode($value, true);

        return Commission::fromArray(
            $commission['type'],
            $this->getCommissionValues($commission),
            $commission['maximumValueCap'] ?? null,
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

        $commissionValuesCollection = collect($value->getValues()->get());
        $commissionValues = $commissionValuesCollection->map(
            fn (CommissionValue $value) => $value->toArray()
        )->toArray();

        $data = [
            'type' => $value->getType(),
            'values' => $commissionValues,
            'maximumValueCap' =>$value->getMaximumValueCap(),
        ];

        return json_encode($data);
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

    private function getCommissionValues(array $commission): CommissionValuesCollection
    {
        $commissionValues = collect($commission['values'] ?? [])
            ->map(
                function (array $data) {
                    $commission = $this->getCommission($data['commission']);

                    return new CommissionValue($commission, $data['categoryId']);
                }
            )
            ->toArray();

        return new CommissionValuesCollection($commissionValues);
    }
}
