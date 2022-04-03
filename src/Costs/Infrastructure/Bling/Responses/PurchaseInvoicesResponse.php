<?php

namespace Src\Costs\Infrastructure\Bling\Responses;

use Src\Costs\Domain\Models\Contracts\PurchaseInvoice;
use Src\Integrations\Bling\Base\Responses\BaseResponse;

class PurchaseInvoicesResponse extends BaseResponse
{
    private array $data;

    public function __construct(array $data)
    {
        foreach ($data as $invoice) {
            if ($invoice instanceof PurchaseInvoice) {
                $this->data[] = $invoice;
            }
        }

        $this->data = $data;
    }

    public function data()
    {
        return $this->data;
    }
}
