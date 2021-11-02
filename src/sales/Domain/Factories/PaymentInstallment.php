<?php

namespace Src\Sales\Domain\Factories;

use Src\Sales\Domain\Models\Data\Payment\Installment as InstallmentData;
use Src\Sales\Domain\Models\PaymentInstallment as PaymentModel;

class PaymentInstallment
{
    public static function make(InstallmentData $installment): PaymentModel
    {
         return new PaymentModel([
             'id' => $installment->id(),
             'value' => $installment->value(),
             'expires_at' => $installment->expiresAt(),
             'observation' => $installment->observation(),
             'destination' => $installment->destination(),
         ]);
    }
}
