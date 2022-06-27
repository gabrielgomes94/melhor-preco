<?php

namespace Src\Prices\Infrastructure\Laravel\Presentation\Http\Requests\Promotions;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Src\Math\Percentage;
use Src\Prices\Domain\DataTransfer\PromotionSetup;

class CalculatePromotionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'beginDate' => 'required|date_format:d/m/Y',
            'endDate' => 'required|date_format:d/m/Y',
            'discount' => 'required|numeric',
            'marketplaceSlug' => 'nullable|string',
            'marketplaceSubsidy' => 'nullable|numeric',
            'promotionName' => 'required|string',
            'productsMaxLimit' => 'required|integer',
        ];
    }

    public function transform(): PromotionSetup
    {
        return new PromotionSetup(
            beginDate: Carbon::createFromFormat('d/m/Y', $this->input('beginDate')),
            endDate: Carbon::createFromFormat('d/m/Y', $this->input('endDate')),
            discount: Percentage::fromPercentage($this->input('discount')),
            marketplaceSubsidy: Percentage::fromPercentage($this->input('marketplaceSubsidy') ?? 0),
            marketplaceSlug: $this->input('marketplaceSlug') ?? 'magalu',
            name: $this->input('promotionName'),
            productsMaxLimit: $this->input('productsMaxLimit')
        );
    }
}
