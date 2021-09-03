<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageUploaderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'sku' => 'required',
            'file' => 'array|required',
            'file.*' => 'image'
        ];
    }

    public function messages()
    {
        return [
            'sku.required' => 'Código SKU deve estar presente',
            'file.required' => 'Imagens devem estar presentes',
            'file.*.image' => 'O arquivo deve ser uma imagem. Formatos suportados: jpeg, png, bmp, gif, svg, webp',
        ];
    }
}
