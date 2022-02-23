<?php

namespace Src\Marketplaces\Presentation\Presenters;

use Illuminate\Support\Collection;
use Src\Marketplaces\Application\Models\Marketplace;

class MarketplacePresenter
{
    public function present(Marketplace $marketplace): array
    {
        $commissions = $this->presentCommissions($marketplace);

        return [
            'name' => $marketplace->getName(),
            'slug' => $marketplace->getSlug(),
            'commissions' => $commissions,
            'erpId' => $marketplace->getErpId(),
            'uuid' => $marketplace->getUuid(),
            'commissionType' => $marketplace->getCommissionType(),
        ];
    }

    public function presentList(Collection $marketplaces): array
    {
        $presented = $marketplaces->map(function (Marketplace $marketplace) {
            return $this->present($marketplace);
        })->toArray();

        return [
            'marketplaces' => $presented,
        ];
    }

    private function presentCommissions(Marketplace $marketplace): array
    {
        $commissions = $marketplace->getCommissionValues();

        foreach ($commissions as $key => $commission) {
            $commissions[$key] = number_format($commission, '2', ',') . '%';
        }

        return $commissions;
    }
}
