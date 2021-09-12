<?php

namespace Barrigudinha\SaleOrder\ValueObjects\Payment;

use Barrigudinha\SaleOrder\ValueObjects\Payment\Installment;

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
            if ($installment instanceof Installment) {
                $this->installments[] = $installment;
            }
        }
    }
}
