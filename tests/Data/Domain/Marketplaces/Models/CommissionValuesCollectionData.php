<?php

namespace Tests\Data\Domain\Marketplaces\Models;

use Src\Marketplaces\Domain\Models\Commission\Base\CommissionValue;
use Src\Marketplaces\Domain\Models\Commission\Base\CommissionValuesCollection;
use Src\Math\Percentage;

class CommissionValuesCollectionData
{
    public static function make(string $method = 'categoryCommission')
    {
        $data = self::$method();

        return new CommissionValuesCollection($data);
    }

    public static function categoryCommission(): array
    {
        return [
            new CommissionValue(
                Percentage::fromPercentage(10.0),
                '1'
            ),
            new CommissionValue(
                Percentage::fromPercentage(12.8),
                '2'
            ),
            new CommissionValue(
                Percentage::fromPercentage(14.0),
                '3'
            ),
        ];
    }

    private static function uniqueCommission(): array
    {
        return [
            new CommissionValue(
                Percentage::fromPercentage(12.0),
                null,
            ),
        ];
    }
}
