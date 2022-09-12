<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Facades\Excel as ExcelFacade;
use Src\Marketplaces\Domain\Models\Freight\Freight;
use Src\Marketplaces\Domain\Models\Freight\FreightTable;
use Src\Marketplaces\Domain\Models\Freight\FreightTableComponent;
use Src\Marketplaces\Infrastructure\Excel\Imports\FreightTableImport;
use Src\Math\Transformers\NumberTransformer;

class UpdateFreightRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'baseValue' => 'numeric',
            'minimumFreightTableValue' => 'numeric|nullable',
            'freightTable' => 'file|nullable',
        ];
    }

    public function transform(): Freight
    {
        return new Freight(
            $this->validated()['baseValue'],
            $this->validated()['minimumFreightTableValue'],
            $this->getFreightTable()
        );
    }

    private function getFreightTable(): ?FreightTable
    {
        $spreadsheet = $this->validated()['freightTable'] ?? null;

        if (!$spreadsheet) {
            return null;
        }

        $data = ExcelFacade::toCollection(
            new FreightTableImport,
            $spreadsheet,
            null,
            Excel::CSV
        );

        $data = $data->first()->map(function(Collection $collection) {
            $data = $collection->toArray();

            return new FreightTableComponent(
                NumberTransformer::toFloat($data['valor_r']),
                NumberTransformer::toFloat($data['de_kg']),
                NumberTransformer::toFloat($data['ate_kg'] ?? FreightTableComponent::INFINITY)
            );
        });

        return new FreightTable($data->toArray());
    }
}
