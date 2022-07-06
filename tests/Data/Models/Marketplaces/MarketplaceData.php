<?php

namespace Tests\Data\Models\Marketplaces;

use Ramsey\Uuid\Uuid;
use Src\Marketplaces\Domain\Models\Commission\Base\Commission;
use Src\Marketplaces\Domain\Models\Commission\Base\CommissionValue;
use Src\Marketplaces\Domain\Models\Commission\Base\CommissionValuesCollection;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Math\Percentage;
use Src\Users\Infrastructure\Laravel\Models\User;

class MarketplaceData
{
    public static function persisted(User $user, array $data = [], ?string $method = null): Marketplace
    {
        $marketplace = self::make($data, $method);

        if (empty($data['uuid'])) {
            $marketplace->uuid = Uuid::uuid4();
        } else {
            $marketplace->uuid = $data['uuid'];
        }

        $marketplace->user_id = $user->id;
        $marketplace->save();

        return $marketplace;
    }

    public static function make(array $data = [], ?string $method = null): Marketplace
    {
        return new Marketplace(self::data($data, $method));
    }

    public static function data(array $data = [], ?string $method = null): array
    {
        return array_replace(
            [
                'erp_id' => '123456',
                'erp_name' => 'bling',
                'name' => 'Magalu',
                'slug' => 'magalu',
                'is_active' => true,
                'commission' => $method ? self::$method() : self::uniqueCommission(),
            ],
            $data
        );
    }

    private static function categoryCommission(): Commission
    {
        return Commission::fromArray(
            'categoryCommission',
            new CommissionValuesCollection([
                new CommissionValue(Percentage::fromPercentage(12.8), '1'),
                new CommissionValue(Percentage::fromPercentage(12.8), '10')
            ])
        );
    }

    private static function uniqueCommission(): Commission
    {
        return Commission::fromArray(
            'uniqueCommission',
            new CommissionValuesCollection([
                new CommissionValue(Percentage::fromPercentage(12.8))
            ])
        );
    }
}
