<?php

namespace Src\Prices\PriceList\Application\Http\Requests\PriceLog;

use Illuminate\Foundation\Http\FormRequest;

class PriceLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [];
    }
}
