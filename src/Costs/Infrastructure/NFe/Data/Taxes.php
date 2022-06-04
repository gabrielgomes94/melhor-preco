<?php

namespace Src\Costs\Infrastructure\NFe\Data;

use Src\Costs\Domain\Models\Tax as TaxInterface;
use Src\Costs\Infrastructure\NFe\Mappers\TaxesMapper as TaxesMapper;
use Src\Math\Percentage;

class Taxes
{
    private function __construct(
        public readonly Tax $icms,
        public readonly Tax $ipi,
        public readonly Tax $ii,
        public readonly Tax $pis,
        public readonly Tax $cofins,
        public readonly float $totalTaxes
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new static(
            new Tax(
                TaxInterface::ICMS,
                0.0,
                Percentage::fromPercentage(
                    TaxesMapper::getICMS($data)['percentage']
                )
            ),
            new Tax(
                TaxInterface::IPI,
                TaxesMapper::getIPI($data)['value'],
                Percentage::fromPercentage(
                    TaxesMapper::getIPI($data)['percentage']
                ),
            ),
            new Tax(TaxInterface::II, 0.0, Percentage::fromPercentage(0.0)),
            new Tax(
                TaxInterface::PIS,
                TaxesMapper::getPIS($data)['value'],
                Percentage::fromPercentage(
                    TaxesMapper::getPIS($data)['percentage']
                )
            ),
            new Tax(
                TaxInterface::COFINS,
                TaxesMapper::getCOFINS($data)['value'],
                Percentage::fromPercentage(
                    TaxesMapper::getCOFINS($data)['percentage']
                ),
            ),
            $data['vTotTrib'] ?? 0.0
        );
    }

    public function toArray(): array
    {
        return [
            TaxInterface::TOTAL_TAXES => $this->totalTaxes,
            TaxInterface::IPI => $this->ipi->toArray(),
            TaxInterface::ICMS => $this->icms->toArray(),
            TaxInterface::PIS => $this->pis->toArray(),
            TaxInterface::COFINS => $this->cofins->toArray()
        ];
    }
}
