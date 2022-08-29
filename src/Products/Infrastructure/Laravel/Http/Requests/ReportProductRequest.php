<?php

namespace Src\Products\Infrastructure\Laravel\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Src\Products\Domain\DataTransfer\FilterOptions;

class ReportProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sku' => 'nullable|string',
            'category' => 'nullable|string',
            'page' => 'nullable|integer'
        ];
    }

    public function transform(): FilterOptions
    {
        return new FilterOptions(
            sku: $this->input('sku'),
            category: $this->input('category'),
            page: $this->input('page'),
            perPage: 50
        );
    }
}
