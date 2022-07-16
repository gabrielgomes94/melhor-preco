<?php

namespace Src\Prices\Infrastructure\Laravel\Http\Requests\PriceList;

use Illuminate\Foundation\Http\FormRequest;
use Src\Products\Infrastructure\Laravel\Repositories\Options\Options;

class ShowRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [];
    }

    public function getOptions(): Options
    {
        $data = [
            'minimumProfit' => $this->input('minProfit') ?? null,
            'maximumProfit' => $this->input('maxProfit') ?? null,
            'filterKits' => (bool) $this->input('filterKits') ?? false,
            'page' => $this->input('page') ?? 1,
            'sku' => $this->input('sku') ?? null,
            'categoryId' => $this->input('category') ?? null,
            'userId' => auth()->user()->getAuthIdentifier(),
        ];

        return new Options($data);
    }
}
