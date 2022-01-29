<?php

namespace Src\Marketplaces\Domain\UseCases\Contracts;

interface GetCommissionType
{
    public function get(string $marketplaceUuid): string;
}
