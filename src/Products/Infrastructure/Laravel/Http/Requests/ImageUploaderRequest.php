<?php
namespace Src\Products\Infrastructure\Laravel\Http\Requests;

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
            'name' => 'required',
            'brand' => 'required',
            'images' => 'array|required',
            'images.*' => 'image'
        ];
    }

    public function attributes()
    {
        return [
            'brand' => 'marca',
        ];
    }

    public function messages()
    {
        return [
            'sku.required' => 'Código SKU deve estar presente',
            'images.required' => 'Imagens devem estar presentes',
            'images.*.image' => 'O arquivo deve ser uma imagem. Formatos suportados: jpeg, png, bmp, gif, svg, webp',
        ];
    }
}
