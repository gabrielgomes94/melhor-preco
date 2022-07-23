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
            'product' => 'string',
            'store' => 'in:b2w,magalu,mercado-livre,mercado-shops,olist,shopee',
            'freeFreight' => 'boolean',
        ];
    }

    public function validationData()
    {
        return array_merge(
            $this->all(),
            [
                'freeFreight' => (bool) $this->input('freeFreight') ?? false,
            ]
        );
    }

    public function transform(): ?CalculatorForm
    {
        if ($this->isEmpty()) {
            return null;
        }

        $data = $this->all();

        return new CalculatorForm(
            (float) $data['desiredPrice'],
            Percentage::fromPercentage((float) $data['commission'] ?? 0.0),
            Percentage::fromPercentage((float) $data['discount'] ?? 0),
        );
    }

    public function isEmpty(): bool
    {
        return empty($this->all());
    }
}
