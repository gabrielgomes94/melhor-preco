<?php

namespace Tests\Data\Models\Marketplaces;

use Src\Marketplaces\Domain\Models\Freight\Freight;
use Src\Marketplaces\Domain\Models\Freight\FreightTable;
use Src\Marketplaces\Domain\Models\Freight\FreightTableComponent;

class FreightData
{
    public static function olist(): Freight
    {
        return new Freight(
            5,
            79,
            new FreightTable([
                new FreightTableComponent(22.14, 0, 0.5),
                new FreightTableComponent(23.94, 0.501, 1),
                new FreightTableComponent(25.74, 1.001, 2),
                new FreightTableComponent(31.14, 2.001, 5),
                new FreightTableComponent(44.94, 5.001, 9),
                new FreightTableComponent(70.74, 9.001, 13),
                new FreightTableComponent(78.54, 13.001, 17),
                new FreightTableComponent(91.74, 17.001, 23),
                new FreightTableComponent(106.14, 23.001, 30),
                new FreightTableComponent(119.94, 30.001, 33),
                new FreightTableComponent(125.94, 33.001, 37),
                new FreightTableComponent(132.54, 37.001, 41),
                new FreightTableComponent(139.14, 41.001, 45),
                new FreightTableComponent(145.74, 45.001, 50),
                new FreightTableComponent(152.94, 50.001),
            ])
        );
    }
}
