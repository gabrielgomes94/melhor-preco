<?php

namespace Src\Sales\Infrastructure\Laravel\Models\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Src\Sales\Domain\Factories\Item;
use Src\Sales\Domain\Models\ValueObjects\Items\Items;

class ItemsCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        foreach ($model->items as $item) {
            $items[] = Item::make($item);
        }

        return new Items($items ?? []);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        // TODO: Implement set() method.
    }
}
