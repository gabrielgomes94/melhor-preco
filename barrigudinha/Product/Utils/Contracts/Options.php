<?php

namespace Barrigudinha\Product\Utils\Contracts;

interface Options
{
    public function hasPagination(): bool;
    public function hasProfitFilters(): bool;
    public function maximumProfit(): float;
    public function minimumProfit(): float;
    public function page(): ?int;
    public function perPage(): ?int;
    public function query(): array;
    public function shouldFilterKits(): bool;
    public function sku(): ?string;
    public function store(): ?string;
    public function url(): string;
}
