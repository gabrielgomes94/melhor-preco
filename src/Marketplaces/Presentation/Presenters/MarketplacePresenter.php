<?php

namespace Src\Marketplaces\Presentation\Presenters;

use Illuminate\Support\Collection;
use Src\Marketplaces\Application\Models\Marketplace;

class MarketplacePresenter
{
    public function present(Collection $marketplaces)
    {
        $presented = $marketplaces->map(function (Marketplace $marketplace) {
            $commissions = $this->presentCommissions($marketplace);

            return [
                'name' => $marketplace->getName(),
                'slug' => $marketplace->getSlug(),
                'commissions' => $commissions,
                'erpId' => $marketplace->getErpId(),
                'uuid' => $marketplace->getUuid(),
            ];
        })->toArray();

        return [
            'marketplaces' => $presented,
        ];
    }

    private function presentCommissions(Marketplace $marketplace)
    {
        $commissions = $marketplace->getCommissionValues();

        foreach ($commissions as $key => $commission) {
            $commissions[$key] = number_format($commission, '2', ',') . '%';
        }

        return $commissions;
    }
}
