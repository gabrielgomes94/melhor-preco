<?php

namespace App\Http\Requests\Pricing\PriceList\ByStore;

use App\Http\Requests\Contracts\HasOptions;
use App\Http\Requests\Product\Options;
use Barrigudinha\Product\Utils\Contracts\Options as OptionsInterface;
use Illuminate\Foundation\Http\FormRequest;

class ShowRequest extends FormRequest implements HasOptions
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
            'page' => $this->input('page'),
            'sku'=> $this->input('sku') ?? null,
        ];

        return new Options($data);
    }
}
