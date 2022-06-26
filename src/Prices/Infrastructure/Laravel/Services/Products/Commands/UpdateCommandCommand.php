<?php

namespace Src\Prices\Infrastructure\Laravel\Services\Products\Commands;

use Src\Prices\Domain\Exceptions\SyncERPException;
use Src\Prices\Domain\Exceptions\UpdateDBException;
use Src\Prices\Domain\UseCases\Products\UpdateCommand as UpdateInterface;
use Src\Products\Domain\Models\Post\Contracts\Post;

// @todo: renomear para Commands
class UpdateCommandCommand implements UpdateInterface
{
    private UpdateDBCommandCommand $updatePriceServiceDB;
    private UpdateERPCommandCommand $updatePriceServiceERP;

    public function __construct(UpdateDBCommandCommand $updatePriceServiceDB, UpdateERPCommandCommand $updatePriceServiceERP)
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
