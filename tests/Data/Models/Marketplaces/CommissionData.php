<?php

namespace Tests\Data\Models\Marketplaces;

use Src\Marketplaces\Domain\Models\Commission\Base\Commission;
use Src\Marketplaces\Domain\Models\Commission\Base\CommissionValue;
use Src\Marketplaces\Domain\Models\Commission\Base\CommissionValuesCollection;
use Src\Math\Percentage;

class CommissionData
{
    public static function magalu(): Commission
    {
        return Commission::build(
            Commission::CATEGORY_COMMISSION,
            new CommissionValuesCollection([
                new CommissionValue(Percentage::fromPercentage(12.8), '1'),
                new CommissionValue(Percentage::fromPercentage(10.2), '10'),
                new CommissionValue(Percentage::fromPercentage(10.2), '11')
            ])
        );
    }

    public static function olist(): Commission
    {
        return Commission::build(
            Commission::UNIQUE_COMMISSION,
            new CommissionValuesCollection([
                new CommissionValue(Percentage::fromPercentage(20))
            ])
        );
    }

    public static function shopee(): Commission
    {
        return Commission::build(
            Commission::UNIQUE_COMMISSION,
            new CommissionValuesCollection([
                new CommissionValue(Percentage::fromPercentage(12))
            ]),
            100
        );
    }

    public static function physicalStore(): Commission
    {
        return Commission::build(
            Commission::UNIQUE_COMMISSION,
            new CommissionValuesCollection([
                new CommissionValue(Percentage::fromPercentage(0))
            ])
        );
    }
}
