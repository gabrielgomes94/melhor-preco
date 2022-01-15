<?php

namespace Src\Calculator\Domain\Models\Price\Freight;

use Src\Calculator\Domain\Transformer\PercentageTransformer;
use Money\Money;
use Src\Calculator\Domain\Transformer\MoneyTransformer;
use Src\Calculator\Domain\Models\Price\Freight\BaseFreight;
use function config;

class MercadoLivre extends BaseFreight
{
    public const FREE_MIN_VALUE = 79.0;

    public function __construct($dimensions, Money $price)
    {
        parent::__construct($dimensions, $price);
    }

    protected function calculate(): Money
    {
        $weight = $this->getWeight();
        $freightTable = $this->getFreightTable();

        return $this->consultFreightTable($weight, $freightTable);
    }

    private function getFreightTable(): array
    {
        $freeMinValue = MoneyTransformer::toMoney(self::FREE_MIN_VALUE);

        if ($this->price->lessThanOrEqual($freeMinValue)) {
            return config('freight_tables.mercado_livre.free_freight_table_1');
        }

        return config('freight_tables.mercado_livre.free_freight_table_2');
    }
}
