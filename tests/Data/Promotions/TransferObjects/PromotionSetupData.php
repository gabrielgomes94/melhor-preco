<?php

namespace Tests\Data\Promotions\TransferObjects;

use Carbon\Carbon;
use Src\Math\Percentage;
use Src\Promotions\Domain\Data\TransferObjects\PromotionSetup;

class PromotionSetupData
{
    public static function getPayload(): array
    {
        return [
            'beginDate' => Carbon::createFromFormat('d-m-Y', '01-01-2021'),
            'endDate' => Carbon::createFromFormat('d-m-Y', '31-01-2021'),
            'discount' => Percentage::fromFraction(5),
            'marketplaceSubsidy' => Percentage::fromFraction(0),
            'minimumMargin' => Percentage::fromPercentage(5.0),
            'marketplaceSlug' => 'zxcv-store',
            'name' => 'ZXCV',
            'productsMaxLimit' => 100,
        ];
    }

    public static function create(array $overwrite = []): PromotionSetup
    {
        $data = array_merge_recursive(
            self::getPayload(),
            $overwrite
        );

        return PromotionSetup::fromArray($data);
    }
}
