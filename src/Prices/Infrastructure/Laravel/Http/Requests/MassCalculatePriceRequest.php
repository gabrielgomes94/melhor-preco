<?php

namespace Src\Prices\Infrastructure\Laravel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Src\Prices\Domain\DataTransfer\MassCalculatorForm;

class MassCalculatePriceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category' => 'string|nullable',
            'value' => 'numeric',
            'calculationType' => 'string|in:markup,discount,addition',
        ];
    }

    public function validationData(): array
    {
        return array_merge(
            $this->all(),
            [
                'ignoreFreight' => (bool) $this->input('ignoreFreight') ?? false,
            ]
        );
    }

    public function transform(): MassCalculatorForm
    {
        return new MassCalculatorForm(
            value: $this->validated()['value'],
            calculationType: $this->validated()['calculationType'],
            category: $this->validated()['category'] ?? null,
        );
    }
}
