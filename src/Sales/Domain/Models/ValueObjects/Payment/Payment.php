<?php

namespace Src\Sales\Domain\Models\ValueObjects\Payment;

class Payment
{
    private array $installments;

    public function __construct(array $installments)
    {
        $this->build($installments);
    }

    public function get(): array
    {
        return $this->installments ?? [];
    }

    public function toArray(): array
    {
        return array_map(function (Installment $installment) {
            return $installment->toArray();
        }, $this->installments);
    }

    private function build(array $installments): void
    {
        foreach ($installments as $installment) {
            if ($installment instanceof Installment) {
                $this->installments[] = $installment;
            }
        }
    }
}
