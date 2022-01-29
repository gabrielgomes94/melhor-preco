<?php

namespace Src\Marketplaces\Application\UseCases;

use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Marketplaces\Domain\UseCases\Contracts\GetCommissionType as GetCommissionTypeInterface;

class GetCommissionType implements GetCommissionTypeInterface
{
    public function get(string $marketplaceUuid): string
    {
        $marketplace = Marketplace::find('uuid', $marketplaceUuid);

        if (!$marketplace) {
            throw new \Exception('Markeplace not found');
        }

        return $marketplace->getCommissionType();
    }
}
