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
            'markup' => 'numeric',
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
            markup: $this->validated()['markup'],
            category: $this->validated()['category'] ?? null,
        );
    }
}
