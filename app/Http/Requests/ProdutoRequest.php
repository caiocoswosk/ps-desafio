<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdutoRequest extends FormRequest
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
            'nome' => ['required', 'min:3', 'max:100'],
            'imagem' => 'image'
        ];
    }

    public function messages(){
        return [
            'nome.required' => 'Esse campo é obrigatório!',
            'nome.min' => 'O nome do produto deve conter no mínimo 3 caracteres!',
            'nome.max' => 'O nome do produto deve conter no máximo 100 caracteres!',
            'imagem.image' => 'É necessário que a imagem seja de um tipo válido!'
        ];
    }
}
