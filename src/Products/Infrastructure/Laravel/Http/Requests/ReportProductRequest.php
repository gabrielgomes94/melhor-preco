<?php

namespace Src\Products\Infrastructure\Laravel\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Src\Products\Application\Data\FilterOptions;

class ReportProductRequest extends FormRequest
{
    private const DATE_FORMAT = 'd/m/Y';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sku' => 'nullable|string',
            'category' => 'nullable|string',
            'page' => 'nullable|integer',
            'beginDate' => 'nullable|date_format:' . self::DATE_FORMAT,
            'endDate' => 'nullable|date_format:' . self::DATE_FORMAT,
        ];
    }

    public function transform(): FilterOptions
    {
        return new FilterOptions(
            sku: $this->input('sku'),
            category: $this->input('category'),
            page: $this->input('page'),
            beginDate: $this->getConvertedDate('beginDate'),
            endDate: $this->getConvertedDate('endDate')
        );
    }

    private function getConvertedDate(string $attribute): ?Carbon
    {
        $data = $this->input($attribute);

        if (!$data) {
            return null;
        }

        return Carbon::createFromFormat(self::DATE_FORMAT, $data);
    }
}
