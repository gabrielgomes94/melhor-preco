<?php

namespace Src\Users\Infrastructure\Laravel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Src\Users\Infrastructure\Laravel\Rules\FiscalId;
use Src\Users\Infrastructure\Laravel\Rules\Phone;

class UpdateProfile extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'fiscal_id' => ['required', new FiscalId()],
            'phone' => ['required', new Phone()],
        ];
    }

    public function validationData(): array
    {
        $input = $this->all();
        $input['phone'] = $this->formatPhone($input['phone'] ?? '');
        $input['fiscal_id'] = $this->removeNonDigits($input['fiscal_id']);

        return $input;
    }

    private function formatPhone(string $phone): string
    {
        return '+55' . $this->removeNonDigits($phone);
    }

    private function removeNonDigits(string $data): string
    {
        return preg_replace('/[^0-9]/', '', $data);
    }
}
