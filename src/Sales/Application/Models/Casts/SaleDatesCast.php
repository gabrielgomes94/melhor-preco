<?php

namespace Src\Sales\Application\Models\Casts;

use Exception;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Src\Sales\Domain\Models\ValueObjects\SaleDates;

class SaleDatesCast implements CastsAttributes
{
    /**
     * @inheritDoc
     */
    public function get($model, string $key, $value, array $attributes)
    {
        return new SaleDates(
            selledAt: $model->selled_at,
            dispatchedAt: $model->dispatched_at,
            expectedArrivalAt: $model->expected_arrival_at
        );
    }

    /**
     * @inheritDoc
     */
    public function set($model, string $key, $value, array $attributes)
    {
        if (!$value instanceof SaleDates) {
            throw new Exception('Invalid type of value');
        }

        return [
            'selled_at' => $value->selledAt(),
            'dispatched_at' => $value->dispatchedAt(),
            'expected_arrival_at' => $value->expectedArrivalAt(),
        ];
    }
}
