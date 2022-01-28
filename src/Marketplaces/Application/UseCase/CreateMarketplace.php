<?php

namespace Src\Marketplaces\Application\UseCase;

use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Marketplaces\Domain\UseCase\Contracts\CreateMarketplace as CreateMarketplaceInterface;

class CreateMarketplace implements CreateMarketplaceInterface
{
    public function create(array $data): bool
    {
        if ($this->storeExists($data)) {
            return false;
        }

        $slug = Str::slug($data['name']);

        Marketplace::create([
            'erp_id' => $data['erpId'],
            'erp_name' => 'bling',
            'name' => $data['name'],
            'slug' => $slug,
            'extra' => [
                'commissionType' => $data['commissionType'],
            ],
            'uuid' => Uuid::uuid4(),
        ]);

        return true;
    }

    private function storeExists(array $data): bool
    {
        $store = Marketplace::where('name', $data['name'])
            ->orWhere('erp_id', $data['erpId'])
            ->get();

        return $store->count() > 0;
    }
}
