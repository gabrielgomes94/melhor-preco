<?php

namespace Src\Prices\Domain\Price\Freight;

use Barrigudinha\Utils\Helpers;
use Money\Money;
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
        $freeMinValue = Helpers::floatToMoney(self::FREE_MIN_VALUE);

        if ($this->price->lessThanOrEqual($freeMinValue)) {
            return config('freight_tables.mercado_livre.free_freight_table_1');
        }

        return config('freight_tables.mercado_livre.free_freight_table_2');
    }
}
