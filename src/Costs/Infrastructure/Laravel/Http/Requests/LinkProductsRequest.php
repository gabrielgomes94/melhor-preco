<?php

namespace Src\Costs\Infrastructure\Laravel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LinkProductsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'products' => 'array',
        ];
    }
}
