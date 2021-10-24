<?php

namespace Src\Prices\Price\Application\Services\Products;

use Src\Prices\Price\Application\Services\Exceptions\UpdateDBException;
use Src\Prices\Price\Application\Services\Exceptions\SyncERPException;
use Src\Prices\Price\Domain\Contracts\Services\Update as UpdateInterface;
use Src\Products\Domain\Product\Contracts\Models\Post;

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
     * @throws \Src\Prices\Price\Application\Services\Exceptions\UpdateDBException
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
