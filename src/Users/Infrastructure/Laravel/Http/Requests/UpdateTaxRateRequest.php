<?php

namespace Src\Users\Infrastructure\Laravel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Src\Math\Percentage;
use Src\Users\Domain\ValueObjects\Taxes;

class UpdateTaxRateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'simplesNacionalTax' => 'numeric',
            'icmsTax' => 'numeric',
        ];
    }

    public function validationData(): array
    {
        return [
            'simplesNacionalTax' => (float) $this->transformNumericInput(
                $this->input('simplesNacionalTax')
            ),
            'icmsTax' => (float) $this->transformNumericInput(
                $this->input('icmsTax')
            ),
        ];
    }

    public function transform(): Taxes
    {
        return new Taxes(
            Percentage::fromPercentage($this->validated()['simplesNacionalTax']),
            Percentage::fromPercentage($this->validated()['icmsTax']),
        );
    }

    private function transformNumericInput(string $input): string
    {
        return str_replace(',', '.', $input);
    }
}
