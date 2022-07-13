<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Facades\Excel as ExcelFacade;
use Src\Marketplaces\Domain\Models\Freight\Freight;
use Src\Marketplaces\Domain\Models\Freight\FreightTable;
use Src\Marketplaces\Domain\Models\Freight\FreightTableComponent;
use Src\Marketplaces\Infrastructure\Laravel\Imports\FreightTableImport;
use Src\Math\Number;

class UpdateCommissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'baseValue' => 'numeric',
            'minimumFreightTableValue' => 'numeric',
            'freightTable' => 'file',
        ];
    }

    public function transform(): Freight
    {
        $spreadsheet = $this->validated()['freightTable'];

        $data = ExcelFacade::toCollection(
            new FreightTableImport,
            $spreadsheet,
            null,
            Excel::CSV
        );

        $data = $data->first()->map(function(Collection $collection) {
            $data = $collection->toArray();

            return new FreightTableComponent(
                Number::transform($data['valor']),
                Number::transform($data['peso_cubico_inicial_kg']),
                Number::transform($data['peso_cubico_final_kg'])
            );
        });

        $freightTable = new FreightTable($data->toArray());

        return new Freight(
            $this->validated()['baseValue'],
            $this->validated()['minimumFreightTableValue'],
            $freightTable
        );
    }
}
