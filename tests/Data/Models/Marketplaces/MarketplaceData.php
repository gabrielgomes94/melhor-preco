<?php

namespace Tests\Data\Models\Marketplaces;

use Ramsey\Uuid\Uuid;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
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
        $data = array_replace_recursive(
            [
                'erp_id' => '123456',
                'erp_name' => 'bling',
                'name' => 'Magalu',
                'slug' => 'magalu',
                'is_active' => true,
                'extra' => $method ? self::$method() : self::uniqueCommission(),
            ],
            $data
        );

        return new Marketplace($data);
    }

    private static function categoryCommission(): array
    {
        return [
            'commissionValues' => [
                [
                    'categoryId' => 1,
                    'commission' => 12.8,
                ]
            ],
            'commissionType' => 'categoryCommission',
        ];
    }

    private static function uniqueCommission(): array
    {
        return [
            'commissionValues' => [
                [
                    'categoryId' => null,
                    'commission' => 12.8,
                ]
            ],
            'commissionType' => 'uniqueCommission',
        ];
    }
}
