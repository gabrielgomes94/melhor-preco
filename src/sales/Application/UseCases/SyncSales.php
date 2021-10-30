<?php

namespace Src\Sales\Application\UseCases;

use Src\Sales\Domain\Contracts\Repository\ErpRepository;
use Src\Sales\Domain\Contracts\UseCases\SyncSales as SyncSalesInterface;

class SyncSales implements SyncSalesInterface
{
    private ErpRepository $erpRepository;

    public function __construct(ErpRepository $erpRepository)
    {
        $this->erpRepository = $erpRepository;
    }

    public function sync(): void
    {
        $data = $this->erpRepository->list();

        dd($data);
    }
}
