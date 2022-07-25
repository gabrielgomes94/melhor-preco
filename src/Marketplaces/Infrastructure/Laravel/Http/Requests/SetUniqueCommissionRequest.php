<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Src\Marketplaces\Domain\Models\Commission\Base\CommissionValue;
use Src\Marketplaces\Domain\Models\Commission\Base\CommissionValuesCollection;
use Src\Math\Percentage;

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
            'commissionMaximumCap' => 'nullable|numeric',
        ];
    }

    public function transform(): CommissionValuesCollection
    {
        $commission = (float) $this->validated()['commission'];

        return new CommissionValuesCollection([
            new CommissionValue(
                Percentage::fromPercentage($commission),
            )],
            $this->validated()['commissionMaximumCap'] ?? null
        );
    }
}
