<?php

namespace Src\Products\Application\Http\Requests\Product;

use App\Http\Requests\Contracts\HasOptions;
use App\Http\Requests\Contracts\HasSKU;
use App\Http\Requests\Utils\ProductOptions;
use Src\Products\Domain\Contracts\Utils\Options as OptionsInterface;
use Illuminate\Foundation\Http\FormRequest;

class EditCostsRequest extends FormRequest implements HasOptions, HasSku
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
        $perPage = 40;

        return new ProductOptions([
            'page' => $this->input('page') ?? 1,
            'perPage' => $perPage,
            'sku' => $this->input('sku') ?? null,
            'path' => $this->url(),
            'query' => $this->query(),
        ]);
    }

    public function getSku(): ?string
    {
        return $this->input('sku') ?? null;
    }
}
