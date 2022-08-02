<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Models\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use InvalidArgumentException;
use Src\Marketplaces\Domain\Models\Freight\Freight;
use Src\Marketplaces\Domain\Models\Freight\FreightTable;
use Src\Marketplaces\Domain\Models\Freight\FreightTableComponent;

class FreightCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        $freight = json_decode($value, true);

        $freightTable = collect($freight['freightTable'] ?? []);
        $freightTable = $freightTable->map(function (array $data) {
            return new FreightTableComponent(
                $data['value'],
                $data['initialCubicWeight'],
                $data['endCubicWeight']
            );
        })->toArray();
        $freightTable = new FreightTable($freightTable);

        return new Freight(
            $freight['defaultValue'] ?? 0.0,
            $freight['minimumFreightTableValue'] ?? 0.0,
            $freightTable,
        );
    }

    public function set($model, string $key, $value, array $attributes)
    {
        if (!$value instanceof Freight) {
            throw new InvalidArgumentException('The given value is not a Freight instance.');
        }

        $freightTable = $value->freightTable?->get() ?? [];
        $freightTable = collect($freightTable);
        $freightTable->map(function (FreightTableComponent $component) {
            return [
                'initialCubicWeight' => $component->initialCubicWeight,
                'endCubicWeight' => $component->endCubicWeight,
                'value' => $component->value,
            ];
        })->toArray();

        $data = [
            'defaultValue' => $value->defaultValue,
            'minimumFreightTableValue' => $value->minimumFreightTableValue,
            'freightTable' => $freightTable,
        ];

        return json_encode($data);
    }
}
