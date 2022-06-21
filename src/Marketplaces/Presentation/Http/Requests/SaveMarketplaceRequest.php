<?php

namespace Src\Marketplaces\Presentation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Src\Marketplaces\Domain\DataTransfer\MarketplaceSettings;

class SaveMarketplaceRequest extends FormRequest
{
    public function validationData()
    {
        return array_merge(
            $this->all(),
            [
                'is_active' => $this->isActive(),
            ]
        );
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'commissionType' => 'required',
            'erpId' => 'required',
            'name' => 'required',
            'is_active' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'commissionType.required' => 'Tipo de Comissão deve ser escolhida.',
            'erpId.required' => 'ID do Marketplace no Bling deve ser preenchido',
            'name.required' => 'Nome do marketplace deve ser preenchido',
        ];
    }

    public function isActive(): bool
    {
        return $this->input('status') ?? false;
    }

    public function transform(): MarketplaceSettings
    {
        $data = $this->validated();

        return new MarketplaceSettings(
            $data['erpId'],
            $data['name'],
            $data['is_active'],
            $data['commissionType'],
            auth()->user()->id
        );
    }
}
