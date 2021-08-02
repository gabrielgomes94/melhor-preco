<?php

namespace App\Repositories\Product\Options;

class Options
{
    private ?float $minimumProfit;
    private ?float $maximumProfit;
    private bool $kits;

    public function __construct(array $data)
    {
        $this->minimumProfit = isset($data['minimumProfit'])
            ? (float) $data['minimumProfit']
            : null;

        $this->maximumProfit = isset($data['maximumProfit'])
            ? (float) $data['maximumProfit']
            : null;

        $this->kits = (bool) $data['filterKits'];
    }

    public function hasProfitFilters(): bool
    {
        return isset($this->maximumProfit) || isset($this->minimumProfit);
    }

    public function maximumProfit(): float
    {
        return $this->maximumProfit ?? 100000000000000000;
    }

    public function minimumProfit(): float
    {
        return $this->minimumProfit ?? -100000000000000000;
    }

    public function filterKits(): bool
    {
        return $this->kits;
    }
}
