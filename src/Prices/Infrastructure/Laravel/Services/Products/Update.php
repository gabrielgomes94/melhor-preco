<?php

namespace Src\Prices\Infrastructure\Laravel\Services\Products;

use Src\Prices\Domain\Exceptions\SyncERPException;
use Src\Prices\Domain\Exceptions\UpdateDBException;
use Src\Prices\Domain\UseCases\Update as UpdateInterface;
use Src\Products\Domain\Models\Post\Contracts\Post;

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
     * @throws \Src\Prices\Domain\Exceptions\UpdateDBException
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
