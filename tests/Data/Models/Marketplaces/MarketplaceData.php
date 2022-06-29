<?php

namespace Tests\Data\Models\Marketplaces;

use Ramsey\Uuid\Uuid;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Users\Infrastructure\Laravel\Models\User;

class MarketplaceData
{
    public static function persisted(User $user, array $data = []): Marketplace
    {
        $marketplace = self::make($data);

        if (empty($data['uuid'])) {
            $marketplace->uuid = Uuid::uuid4();
        } else {
            $marketplace->uuid = $data['uuid'];
        }

        $marketplace->user_id = $user->id;
        $marketplace->save();

        return $marketplace;
    }

    public static function make(array $data = []): Marketplace
    {
        $data = array_merge(
            [
                'erp_id' => '123456',
                'erp_name' => 'bling',
                'name' => 'Magalu',
                'slug' => 'magalu',
                'extra' => [
                    'commissionValues' => [
                        [
                            'categoryId' => null,
                            'commission' => 12.8,
                        ]
                    ],
                    'commissionType' => 'uniqueCommission'
                ],
                'is_active' => true,
            ],
            $data
        );

        return new Marketplace($data);
    }
}
