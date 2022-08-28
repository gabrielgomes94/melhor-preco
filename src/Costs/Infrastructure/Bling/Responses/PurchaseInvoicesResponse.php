<?php

namespace Src\Costs\Infrastructure\Bling\Responses;

use Src\Costs\Domain\Models\PurchaseInvoice;
use Src\Integrations\Bling\Base\Responses\BaseResponse;

class PurchaseInvoicesResponse extends BaseResponse
{
    private array $data;

    public function __construct(array $data)
    {
        $this->setData($data);
    }

    public function data(): array
    {
        return $this->data;
    }

    private function setData(array $data): void
    {
        foreach ($data as $invoice) {
            if ($invoice instanceof PurchaseInvoice) {
                $this->data[] = $invoice;
            }
        }

        $this->data = $data;
    }
}
