<?php

namespace Src\Products\Presentation\Http\Requests\Product;

use Src\Products\Presentation\Http\Requests\Product\Contracts\HasOptions;
use Src\Products\Infrastructure\Laravel\Repositories\Options\Options;
use Src\Products\Domain\Utils\Contracts\Options as OptionsInterface;
use Illuminate\Foundation\Http\FormRequest;

class EditCostsRequest extends FormRequest implements HasOptions
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

        return new Options([
            'page' => $this->input('page') ?? 1,
            'perPage' => $perPage,
            'sku' => $this->input('sku') ?? null,
            'path' => $this->url(),
            'query' => $this->query(),
        ]);
    }
}
