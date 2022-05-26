<?php

namespace Src\Costs\Infrastructure\Laravel\Http\Requests;

use Src\Products\Application\Data\FilterOptions;
use Illuminate\Foundation\Http\FormRequest;

class ListProductCostsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [];
    }

    public function getOptions(): FilterOptions
    {
        $perPage = 40;

        return new FilterOptions(
            sku: $this->input('sku'),
            category: $this->input('category'),
            page: $this->input('page'),
            perPage: $perPage,
        );
    }
}
