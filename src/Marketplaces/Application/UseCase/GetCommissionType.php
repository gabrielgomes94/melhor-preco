<?php

namespace Src\Marketplaces\Application\UseCase;

use Src\Marketplaces\Domain\Models\Marketplace;

class GetCommissionType
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
