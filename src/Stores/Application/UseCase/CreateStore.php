<?php

namespace Src\Stores\Application\UseCase;

use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;
use Src\Stores\Domain\Store;
use Src\Stores\Domain\UseCase\Contracts\CreateStore as CreateStoreInterface;

class CreateStore implements CreateStoreInterface
{
    public function create(array $data): bool
    {
        $slug = Str::slug($data['name']);

        $store = Store::create([
            'erp_id' => $data['erpId'],
            'erp_name' => 'bling',
            'name' => $data['erpName'],
            'slug' => $slug,
            'extra' => [],
            'uuid' => Uuid::uuid4(),
        ]);

        return $store;
    }
}
