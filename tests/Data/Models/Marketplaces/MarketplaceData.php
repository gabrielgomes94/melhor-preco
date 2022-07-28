<?php

namespace Tests\Data\Models\Marketplaces;

use Ramsey\Uuid\Uuid;
use Src\Marketplaces\Domain\Models\Commission\Base\Commission;
use Src\Marketplaces\Domain\Models\Commission\Base\CommissionValue;
use Src\Marketplaces\Domain\Models\Commission\Base\CommissionValuesCollection;
use Src\Marketplaces\Domain\Models\Freight\Freight;
use Src\Marketplaces\Domain\Models\Freight\FreightTable;
use Src\Marketplaces\Domain\Models\Freight\FreightTableComponent;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Math\Percentage;
use Src\Users\Infrastructure\Laravel\Models\User;

class MarketplaceData
{
    /**
     * Marketplace with category commissions and no freight table
     */
    public static function magalu(User $user): Marketplace
    {
        return self::persisted($user, [
            'name' => 'Magalu',
            'slug' => 'magalu',
            'erp_id' => '123456',
            'commission' => CommissionData::magalu(),
            'freight' => new Freight(),
            'uuid' => '0ba73120-6944-4ac4-8357-cef9b410ff54',
        ]);
    }

    /**
     * Marketplace with single commission, maximum commission cap and no freight table
     */
    public static function shopee(User $user): Marketplace
    {
        return self::persisted($user, [
            'name' => 'Shopee',
            'slug' => 'shopee',
            'erp_id' => '123457',
            'commission' => CommissionData::shopee(),
            'freight' => new Freight(),
            'uuid' => '9dbc1291-e85a-4d9f-a0d6-43f001643dcc',
        ]);
    }

    /**
     * Marketplace with single commission, and freight table
     */
    public static function olist(User $user): Marketplace
    {
        return self::persisted($user, [
            'name' => 'Olist',
            'slug' => 'olist',
            'erp_id' => '123458',
            'commission' => CommissionData::olist(),
            'freight' => FreightData::olist(),
            'uuid' => '7e664e49-bb7c-40e6-a481-a92cf61684c1',
        ]);
    }

    private static function persisted(User $user, array $data = []): Marketplace
    {
        $marketplace = new Marketplace($data);
        $marketplace->erp_name = 'bling';

        if (empty($data['uuid'])) {
            $marketplace->uuid = Uuid::uuid4();
        } else {
            $marketplace->uuid = $data['uuid'];
        }

        $marketplace->user_id = $user->id;
        $marketplace->save();

        return $marketplace;
    }
}
