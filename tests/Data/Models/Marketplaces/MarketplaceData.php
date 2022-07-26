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

    public static function magalu(User $user): Marketplace
    {
        return self::persisted($user, [
            'name' => 'Magalu',
            'slug' => 'magalu',
            'erp_id' => '123456',
            'commission' => self::categoryCommission(),
            'uuid' => '0ba73120-6944-4ac4-8357-cef9b410ff54',
        ]);
    }

    public static function shopee(User $user): Marketplace
    {
        return self::persisted($user, [
            'name' => 'Shopee',
            'slug' => 'shopee',
            'erp_id' => '123456',
            'commission' => self::uniqueCommission(),
            'uuid' => '9dbc1291-e85a-4d9f-a0d6-43f001643dcc',
        ]);
    }

    private static function categoryCommission(): Commission
    {
        return Commission::fromArray(
            'categoryCommission',
            new CommissionValuesCollection([
                new CommissionValue(Percentage::fromPercentage(12.8), '1'),
                new CommissionValue(Percentage::fromPercentage(10.2), '10')
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
