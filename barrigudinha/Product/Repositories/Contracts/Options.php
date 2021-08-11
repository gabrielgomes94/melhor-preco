<?php

namespace Barrigudinha\Product\Repositories\Contracts;

interface Options
{
    public function filterKits(): bool;

    public function hasPagination(): bool;

    public function hasProfitFilters(): bool;

    public function page(): ?int;

    public function perPage(): ?int;

    public function maximumProfit(): float;

    public function minimumProfit(): float;

    public function store(): ?string;
}
