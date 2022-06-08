<?php

namespace Src\Costs\Infrastructure\Laravel\Presenters;

use Illuminate\Support\Collection;
use Src\Costs\Infrastructure\Laravel\Models\PurchaseInvoice;
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
            'items' => $invoice->getItems()->map(
                fn (PurchaseItem $item) => PurchaseItemsPresenter::present($item)
            )->all(),
        ];
    }

    public static function presentList(array $collection): array
    {
        $collection = collect($collection);

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
