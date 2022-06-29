<?php

namespace Src\Prices\Infrastructure\Laravel\Services\Products\Commands;

use Src\Prices\Domain\Exceptions\SyncERPException;
use Src\Prices\Domain\Exceptions\UpdateDBException;
use Src\Prices\Domain\UseCases\Products\UpdateCommand as UpdateInterface;
use Src\Products\Domain\Models\Post\Contracts\Post;

class UpdateCommand implements UpdateInterface
{
    private UpdateDBCommand $updatePriceServiceDB;
    private UpdateERPCommand $updatePriceServiceERP;

    public function __construct(UpdateDBCommand $updatePriceServiceDB, UpdateERPCommand $updatePriceServiceERP)
    {
        $this->updatePriceServiceDB = $updatePriceServiceDB;
        $this->updatePriceServiceERP = $updatePriceServiceERP;
    }

    /**
     * @throws UpdateDBException
     */
    public function execute(string $sku, Post $post): bool
    {
        if (!$this->updatePriceServiceDB->execute($post)) {
            throw new UpdateDBException();
        }

//        if (!$this->updatePriceServiceERP->execute($sku, $post)) {
//            throw new SyncERPException();
//        }

        return true;
    }
}
