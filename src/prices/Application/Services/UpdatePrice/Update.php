<?php

namespace Src\Prices\Application\Services\UpdatePrice;

use Src\Prices\Application\Services\UpdatePrice\UpdateDB;
use Src\Prices\Application\Services\UpdatePrice\UpdateERP;
use Src\Prices\Application\Services\UpdatePrice\Exceptions\UpdateDBException;
use Src\Prices\Application\Services\UpdatePrice\Exceptions\SyncERPException;
use Src\Prices\Domain\Contracts\Services\UpdatePrice\Update as UpdateInterface;
use Src\Products\Domain\Entities\Post;

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
