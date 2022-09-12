<?php

namespace Src\Prices\Infrastructure\Laravel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Src\Math\Percentage;
use Src\Prices\Domain\DataTransfer\CalculatorForm;

class CalculatePriceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'desiredPrice' => 'numeric',
            'commission' => 'string',
            'discount' => 'numeric|nullable',
            'freight' => 'numeric|nullable',
        ];
    }

    public function transform(): ?CalculatorForm
    {
        if ($this->isEmpty()) {
            return null;
        }

        $data = $this->validated();

        return new CalculatorForm(
            (float) $data['desiredPrice'],
            (float) $data['freight'] ?? 0,
            Percentage::fromPercentage((float) $data['commission'] ?? 0),
            Percentage::fromPercentage((float) $data['discount'] ?? 0),
        );
    }

    public function isEmpty(): bool
    {
        return empty($this->all());
    }
}
