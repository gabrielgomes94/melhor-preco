<?php

namespace Src\Sales\Domain\Models\Data\Payment;

use Src\Sales\Domain\Models\Data\Payment\Installment;

class Payment
{
    private array $installments;

    public function __construct(array $installments)
    {
        $this->build($installments);
    }

    public function toArray(): array
    {
        return array_map(function (Installment $installment) {
            return $installment->toArray();
        }, $this->installments);
    }

    private function build(array $installments)
    {
        foreach ($installments as $installment) {
            if ($installment instanceof \Src\Sales\Domain\Models\Data\Payment\Installment) {
                $this->installments[] = $installment;
            }
        }
    }
}
