<?php

namespace Src\Promotions\Infrastructure\Laravel\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Src\Math\Percentage;
use Src\Promotions\Domain\Data\TransferObjects\PromotionSetup;

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
        return PromotionSetup::fromArray([
            'beginDate' => $this->convertDate('beginDate'),
            'endDate' => $this->convertDate('endDate'),
            'discount' => $this->convertPercentage('discount'),
            'marketplaceSubsidy' => $this->convertPercentage('marketplaceSubsidy'),
            'minimumMargin' => $this->getMinimumMargin(),
            'marketplaceSlug' => $this->input('marketplaceSlug') ?? 'magalu',
            'name' => $this->input('promotionName'),
            'productsMaxLimit' => $this->input('productsMaxLimit'),
        ]);
    }

    private function convertDate(string $inputName): Carbon
    {
        return Carbon::createFromFormat('d/m/Y', $this->input($inputName));
    }

    private function convertPercentage(string $inputName): Percentage
    {
        return Percentage::fromPercentage($this->input($inputName));
    }

    private function getMinimumMargin(): ?Percentage
    {
        return $this->has('minimumMargin')
            ? $this->convertPercentage('minimumMargin')
            : null;
    }
}
