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

    public function transform(): Options
    {
        return new Options(
            minimumProfit: $this->input('minProfit') ?? null,
            maximumProfit: $this->input('maxProfit') ?? null,
            sku: $this->input('sku') ?? null,
            categoryId: $this->input('category') ?? null,
            userId: auth()->user()->getAuthIdentifier(),
            page: $this->input('page') ?? 1,
            filterKits: (bool) $this->input('filterKits') ?? false,
            marketplaceSlug: $this->segment(3) ?? null,
        );
    }
}
