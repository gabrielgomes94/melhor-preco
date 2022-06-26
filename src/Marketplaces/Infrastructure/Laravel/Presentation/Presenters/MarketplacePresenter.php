<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Presentation\Presenters;

use Illuminate\Support\Collection;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;

class MarketplacePresenter
{
    public function present(Marketplace $marketplace): array
    {
        $commissions = $this->presentCommissions($marketplace);
        $status = $marketplace->isActive() ? 'Ativo' : 'Inativo';

        return [
            'commissionType' => $marketplace->getCommissionType(),
            'commissions' => $commissions,
            'erpId' => $marketplace->getErpId(),
            'isActive' => $marketplace->isActive(),
            'name' => $marketplace->getName(),
            'status' => $status,
            'slug' => $marketplace->getSlug(),
            'uuid' => $marketplace->getUuid(),
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
