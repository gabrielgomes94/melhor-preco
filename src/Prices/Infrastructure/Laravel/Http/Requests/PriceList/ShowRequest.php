<?php

namespace Src\Prices\Infrastructure\Laravel\Http\Requests\PriceList;

use Illuminate\Foundation\Http\FormRequest;
use Src\Math\Transformers\NumberTransformer;
use Src\Products\Infrastructure\Laravel\Repositories\Options\Options;

class ShowRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'minProfit' => 'numeric|nullable',
            'maxProfit' => 'numeric|nullable',
            'sku' => 'string|nullable',
            'category' => 'string|nullable',
            'filterKits' => 'boolean|nullable',
        ];
    }

    public function validationData(): array
    {
        return array_merge($this->all(), [
            'filterKits' => (bool) $this->input('filterKits') ?? false,
            'minProfit' => $this->has('minProfit')
                ? NumberTransformer::toFloat($this->input('minProfit'))
                : null,
            'maxProfit' => $this->has('maxProfit')
                ? NumberTransformer::toFloat($this->input('maxProfit'))
                : null,
        ]);
    }

    public function transform(): Options
    {
        return new Options(
            minimumProfit: $this->input('minProfit') ?? null,
            maximumProfit: $this->input('maxProfit') ?? null,
            sku: $this->input('sku') ?? null,
            categoryId: $this->input('category') ?? null,
            page: $this->input('page') ?? 1,
            filterKits: (bool) $this->input('filterKits') ?? false,
            userId: auth()->user()->getAuthIdentifier(),
        );
    }
}
