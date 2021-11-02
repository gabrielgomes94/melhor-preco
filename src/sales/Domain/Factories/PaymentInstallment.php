<?php

namespace Src\Sales\Domain\Factories;

use Src\Sales\Domain\Models\Data\Payment\Installment as InstallmentData;
use Src\Sales\Domain\Models\PaymentInstallment as PaymentModel;

class PaymentInstallment
{
    public static function make(PaymentModel $model)
    {
        return new InstallmentData(
            id: $model->id,
            value: $model->value,
            expiresAt: $model->expires_at,
            observation: $model->observation,
            destination: $model->destination
        );
    }

    public static function makeModel(InstallmentData $installment): PaymentModel
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
