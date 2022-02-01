<?php

namespace Src\Marketplaces\Presentation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveMarketplaceRequest extends FormRequest
{
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
}