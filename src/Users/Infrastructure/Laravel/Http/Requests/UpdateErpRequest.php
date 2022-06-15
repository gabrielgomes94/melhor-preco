<?php

namespace Src\Users\Infrastructure\Laravel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Src\Users\Domain\DataTransfer\Erp;

class UpdateErpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'erp' => 'required|in:Bling|string',
            'erp_token' => 'required|string'
        ];
    }

    public function transform(): Erp
    {
        return new Erp($this->input('erp_token'), 'bling');
    }
}
