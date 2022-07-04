<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Src\Marketplaces\Domain\DataTransfer\CategoryCommission;
use Src\Math\Percentage;

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
            $commission = (float) $data['commission'][$i] ?? 0.0;

            $transformed[] = new CategoryCommission(
                Percentage::fromPercentage($commission),
                (string) $data['categoryId'][$i],
            );
        }

        return $transformed ?? [];
    }
}
