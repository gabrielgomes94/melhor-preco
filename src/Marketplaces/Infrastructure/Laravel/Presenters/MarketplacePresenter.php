<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Presenters;

use Illuminate\Support\Collection;
use Src\Marketplaces\Domain\DataTransfer\CommissionValue;
use Src\Marketplaces\Domain\Models\Marketplace;

class MarketplacePresenter
{
    public function present(Marketplace $marketplace): array
    {
        $commissions = $this->presentCommissions($marketplace);
        $status = $marketplace->isActive() ? 'Ativo' : 'Inativo';

        return [
            'commissionType' => $marketplace->getCommission()->getType(),
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
        $commissions = $marketplace->getCommission()->getValues();

        return $commissions
            ->map(fn (CommissionValue $data) => $data->commission->get() ?? null)
            ->unique()
            ->sort()
            ->transform(fn (float $data) => $this->formatNumber($data))
            ->toArray();
    }

    private function formatNumber(float $data): string
    {
        return number_format($data, '2', ',') . '%';
    }
}
