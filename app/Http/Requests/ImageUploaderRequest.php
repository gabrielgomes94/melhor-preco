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
            'codigo' => 'required',
            'descricao' => 'required',
            'marca' => 'required',
            'file' => 'array|required',
            'file.*' => 'image'
        ];
    }

    public function messages()
    {
        return [
            'codigo.required' => 'Código SKU deve estar presente',
            'descricao.required' => 'Nome deve estar presente',
            'marca.required' => 'Marca deve estar presente',
            'file.required' => 'Imagens devem estar presentes',
            'file.*.image' => 'O arquivo deve ser uma imagem. Formatos suportados: jpeg, png, bmp, gif, svg, webp',
        ];
    }
}
