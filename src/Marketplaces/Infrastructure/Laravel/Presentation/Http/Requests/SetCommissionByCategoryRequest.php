<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Presentation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Src\Marketplaces\Domain\DataTransfer\CategoryCommission;

class SetCommissionByCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'commission' => 'array',
            'categoryId' => 'array',
        ];
    }

    public function transform(): array
    {
        $data = $this->all();
        $count = count($data['commission']);

        for ($i = 0; $i < $count; $i++) {
            $transformed[] = new CategoryCommission([
                'commission' => $data['commission'][$i],
                'categoryId' => $data['categoryId'][$i],
            ]);

        }

        return $transformed ?? [];
    }
}
