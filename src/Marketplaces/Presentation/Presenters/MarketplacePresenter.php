<?php

namespace Src\Marketplaces\Presentation\Presenters;

use Illuminate\Support\Collection;
use Src\Marketplaces\Domain\Models\Marketplace;

class MarketplacePresenter
{
    public function present(Collection $marketplaces)
    {
        $presented = $marketplaces->map(function (Marketplace $marketplace) {
            return [
                'name' => $marketplace->getName(),
                'slug' => $marketplace->getSlug(),
                'commissions' => $marketplace->getCommissionValues(),
                'erpId' => $marketplace->getErpId(),
                'uuid' => $marketplace->getUuid(),
            ];
        })->toArray();

        return [
            'marketplaces' => $presented,
        ];
    }
}
