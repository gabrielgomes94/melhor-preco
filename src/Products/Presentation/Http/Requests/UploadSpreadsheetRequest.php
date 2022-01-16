<?php

namespace Src\Products\Presentation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadSpreadsheetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => 'required|file|mimes:csv,txt,xlsx',
        ];
    }
}
