<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Repositories;

use Src\Marketplaces\Domain\Models\Freight\Freight;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Products\Domain\Models\Product;

class FreightRepository
{
    public function get(Marketplace $marketplace, float $cubicWeight, float $value): float
    {
        $freight = $marketplace->getFreight();

        if ($value < $freight->minimumFreightTableValue) {
            return $freight->defaultValue;
        }

        if (!$freight->freightTable) {
            return $freight->defaultValue;
        }

        return $freight->getFromTable($cubicWeight);
    }

    public function update(Marketplace $marketplace, Freight $freightSettings): bool
    {
        $marketplace->setFreight($freightSettings);

        return $marketplace->save();
    }
}
