<?php

namespace Src\Prices\Application\Http\Requests\PriceList;

use App\Http\Requests\Contracts\HasOptions;
use Src\Products\Infrastructure\Repositories\Options\Options;
use Src\Products\Domain\Contracts\Utils\Options as OptionsInterface;
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
            'page' => $this->input('page') ?? 1,
            'sku' => $this->input('sku') ?? null,
        ];

        return new Options($data);
    }
}
