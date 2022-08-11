<?php

namespace Src\Users\Infrastructure\Laravel\Models\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use InvalidArgumentException;
use Src\Math\Percentage;
use Src\Users\Domain\Models\ValueObjects\Taxes;

class TaxesCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        $taxes = json_decode($value, true);

        return new Taxes(
            Percentage::fromPercentage($taxes['simplesNacional'] ?? 0.0),
            Percentage::fromPercentage($taxes['icmsInnerState'] ?? 0.0),
        );
    }

    public function set($model, string $key, $value, array $attributes)
    {
        if (!$value instanceof Taxes) {
            throw new InvalidArgumentException('The given value is not a Taxes instance.');
        }

        $data = [
            'simplesNacional' => $value->simplesNacional->get(),
            'icmsInnerState' => $value->icmsInnerState->get(),
        ];

        return json_encode($data);
    }
}
