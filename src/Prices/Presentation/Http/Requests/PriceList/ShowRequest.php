<?php

namespace Src\Prices\Presentation\Http\Requests\PriceList;

use Src\Products\Infrastructure\Laravel\Repositories\Options\Options;
use Src\Products\Domain\Utils\Contracts\Options as OptionsInterface;
use Illuminate\Foundation\Http\FormRequest;

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

    public function getOptions(): OptionsInterface
    {
        $data = [
            'minimumProfit' => $this->input('minProfit') ?? null,
            'maximumProfit' => $this->input('maxProfit') ?? null,
            'filterKits' => (bool) $this->input('filterKits') ?? false,
            'page' => $this->input('page') ?? 1,
            'sku' => $this->input('sku') ?? null,
            'categoryId' => $this->input('category') ?? null,
        ];

        return new Options($data);
    }
}
