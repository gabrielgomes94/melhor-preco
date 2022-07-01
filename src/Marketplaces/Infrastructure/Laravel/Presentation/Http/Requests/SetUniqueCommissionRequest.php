<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Presentation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetUniqueCommissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'commission' => 'numeric',
        ];
    }

    public function transform(): float
    {
        return  (float) $this->validated()['commission'];
    }
}
