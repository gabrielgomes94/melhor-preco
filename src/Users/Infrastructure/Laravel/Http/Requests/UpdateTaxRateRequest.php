<?php

namespace Src\Users\Infrastructure\Laravel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaxRateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tax_rate' => 'numeric',
        ];
    }

    public function validationData(): array
    {
        $taxRate = $this->input('tax_rate');
        $taxRate = str_replace(',', '.', $taxRate);

        return [
            'tax_rate' => (float) $taxRate,
        ];
    }

    public function getTaxRate(): float
    {
        return (float) $this->validated()['tax_rate'];
    }
}
