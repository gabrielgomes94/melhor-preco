<?php

namespace Tests\Data\Models\Marketplaces;

use Ramsey\Uuid\Uuid;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Users\Infrastructure\Laravel\Models\User;

class MarketplaceData
{
    public static function persisted(User $user): Marketplace
    {
        $marketplace = new Marketplace([
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
        ]);
        $marketplace->uuid = Uuid::uuid4();
        $marketplace->user_id = $user->id;
        $marketplace->save();

        return $marketplace;
    }

//    public static function make(): Marketplace
//    {
//    }
}
