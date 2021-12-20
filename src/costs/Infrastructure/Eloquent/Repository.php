<?php

namespace Src\Costs\Infrastructure\Eloquent;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use SimpleXMLElement;
use Src\costs\Domain\Models\PurchaseInvoice;
use Src\Costs\Domain\Repositories\DbRepository;

class Repository implements DbRepository
{
    public function __construct()
    {

    }

    public function listPurchaseInvoice(): Collection
    {
        return PurchaseInvoice::all();
    }

    public function getXml(PurchaseInvoice $purchaseInvoice): SimpleXMLElement
    {
        $data = Http::get($purchaseInvoice->getXmlUrl());

        return new SimpleXMLElement($data->body());
    }
}
