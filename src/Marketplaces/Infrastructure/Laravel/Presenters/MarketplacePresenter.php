<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Presenters;

use Illuminate\Support\Collection;
use Src\Marketplaces\Domain\Models\Commission\Base\CommissionValue;
use Src\Marketplaces\Domain\Models\Freight\FreightTableComponent;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Math\MathPresenter;

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
            'freight' => $this->presentFreight($marketplace),
            'freightTable' => $this->presentFreightTable($marketplace),
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
        $commissions = $marketplace->getCommission()->getValues()->get();

        return collect($commissions)
            ->map(fn (CommissionValue $data) => $data->commission->get() ?? null)
            ->unique()
            ->sort()
            ->transform(fn (float $data) => $this->formatNumber($data))
            ->toArray();
    }

    private function presentFreight(Marketplace $marketplace): array
    {
        $freight = $marketplace->getFreight();
        $freightTable = collect($freight->freightTable?->get() ?? []);
        $freightTable = $freightTable->transform(function(FreightTableComponent $component) {
            return [
                'initialCubicWeight' => $component->initialCubicWeight,
                'endCubicWeight' => $component->endCubicWeight,
                'value' => $component->value,
            ];
        })->toArray();

        return [
            'defaultValue' => $freight->baseValue,
            'minimumFreightTableValue' => $freight->minimumFreightTableValue,
            'freightTable' => $freightTable,
        ];
    }

    private function formatNumber(float $data): string
    {
        return number_format($data, '2', ',') . '%';
    }

    private function presentFreightTable(Marketplace $marketplace): array
    {
        $freight = $marketplace->getFreight();
        $freightTable = collect($freight->freightTable?->get() ?? []);

        return $freightTable->transform(function(FreightTableComponent $component) {
            return [
                'initialCubicWeight' => MathPresenter::float($component->initialCubicWeight),
                'endCubicWeight' => MathPresenter::float($component->endCubicWeight),
                'value' => MathPresenter::money($component->value),
            ];
        })->toArray();
    }
}
