<?php
namespace Barrigudinha\Pricing\Data\Contracts;

interface CreatePricing
{
    public function skuList(): array;

    public function name(): string;

    public function stores(): array;
}
