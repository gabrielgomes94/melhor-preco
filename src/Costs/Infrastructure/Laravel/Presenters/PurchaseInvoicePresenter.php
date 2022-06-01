<?php

namespace Src\Costs\Infrastructure\Laravel\Presenters;

use Illuminate\Support\Collection;
use Src\Costs\Domain\Models\Contracts\PurchaseInvoice;
use Src\Costs\Infrastructure\Laravel\Models\PurchaseItem;

class PurchaseInvoicePresenter
{
    public static function present(PurchaseInvoice $invoice): array
    {
        return [
            'uuid' => $invoice->getUuid(),
            'series' => $invoice->getSeries(),
            'seriesNumber' => "{$invoice->getSeries()} - {$invoice->getNumber()}",
            'issuedAt' => $invoice->getIssuedAt()?->format('d/m/Y'),
            'contactName' => $invoice->getContactName(),
            'number' => $invoice->getNumber(),
            'situation' => $invoice->getSituation(),
            'fiscalId' => $invoice->getFiscalId(),
            'value' => 'R$ ' . $invoice->getValue(),
            'status' => $invoice->getSituation(),
            'freightValue' => 0.0,
            'insuranceValue' => 0.0,
            'items' => $invoice->items->map(function (PurchaseItem $item) {
                return PurchaseItemsPresenter::present($item);
            })->all(),
        ];
    }

    public static function presentList(Collection $collection): array
    {
        $data = $collection->transform(function($model) {
            return [
                'uuid' => $model->getUuid(),
                'series' => $model->getSeries(),
                'seriesNumber' => "{$model->getSeries()} - {$model->getNumber()}",
                'issuedAt' => $model->getIssuedAt()->format('d/m/Y'),
                'contactName' => $model->getContactName(),
                'value' => 'R$ ' . $model->getValue(),
                'status' => $model->getSituation(),
            ];
        });

        return $data->all();
    }
}
