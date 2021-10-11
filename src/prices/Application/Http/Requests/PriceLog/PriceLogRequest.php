<?php

namespace Src\Prices\Application\Http\Requests\PriceLog;

use App\Http\Requests\Contracts\HasOptions;
use App\Http\Requests\Utils\ProductOptions;
use Src\Products\Domain\Contracts\Utils\Options;
use Illuminate\Foundation\Http\FormRequest;

class PriceLogRequest extends FormRequest implements HasOptions
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
            'page' => $this->input('page') ?? 1,
            'sku' => $this->input('sku') ?? null,
        ];

        return new ProductOptions($data);
    }
}
