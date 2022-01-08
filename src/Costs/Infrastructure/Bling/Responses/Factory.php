<?php

namespace Src\Costs\Infrastructure\Bling\Responses;

use Src\Integrations\Bling\Base\Responses\BaseResponse;
use Src\Integrations\Bling\Base\Responses\Factories\BaseFactory;

class Factory extends BaseFactory
{
    public function make(array $data): BaseResponse
    {
        if ($this->isInvalid($data)) {
            return $this->makeError(data: $data);
        }

        foreach ($data as $invoice) {
            $invoice = $invoice['notafiscal'] ?? null;

            if (!$invoice) {
                continue;
            }

            if ($invoice['loja'] === '0') {
                $invoices[] = Transformer::transform($invoice);
            }
        }

        return new PurchaseInvoicesResponse($invoices ?? []);
    }
}
