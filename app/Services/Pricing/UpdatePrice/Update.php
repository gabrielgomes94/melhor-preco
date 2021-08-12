<?php

namespace App\Services\Pricing\UpdatePrice;

use App\Services\Pricing\UpdatePrice\Exceptions\UpdateDBException;
use App\Services\Pricing\UpdatePrice\Exceptions\SyncERPException;
use Barrigudinha\Pricing\Services\UpdatePrice\Contracts\Update as UpdateInterface;
use Barrigudinha\Product\Entities\Post;

class Update implements UpdateInterface
{
    private UpdateDB $updatePriceServiceDB;
    private UpdateERP $updatePriceServiceERP;

    public function __construct(UpdateDB $updatePriceServiceDB, UpdateERP $updatePriceServiceERP)
    {
        $this->updatePriceServiceDB = $updatePriceServiceDB;
        $this->updatePriceServiceERP = $updatePriceServiceERP;
    }

    /**
     * @throws SyncERPException
     * @throws UpdateDBException
     */
    public function execute(string $sku, Post $post): bool
    {
        if (!$this->updatePriceServiceDB->execute($post)) {
            throw new UpdateDBException();
        }

        if (!$this->updatePriceServiceERP->execute($sku, $post)) {
            throw new SyncERPException();
        }

        return true;
    }
}
