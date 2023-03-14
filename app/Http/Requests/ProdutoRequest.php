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
            'preco' => ['required', 'regex:/^[0-9]{1,6}([,.][0-9]{1,2})?$/'],
            'quantidade' => ['required', 'integer'],
            'imagem' => 'image',
            'categoria_id' => ['required', 'integer'],
        ];
    }

    public function messages(){
        return [
            'nome.required' => 'O campo de nome é obrigatório!',
            'nome.min' => 'O nome do produto deve conter no mínimo 3 caracteres!',
            'nome.max' => 'O nome do produto deve conter no máximo 100 caracteres!',
            'preco.required' => 'O campo de preço é obrigatório!',
            'preco.regex' => 'O preço do produto deve ser um valor monetário menor que 1 milhão!',
            'quantidade.required' => 'O campo de quantidade é obrigatório!',
            'quantidade.integer' => 'A quantidade do produto deve ser um número inteiro!',
            'imagem.image' => 'É necessário que a imagem seja de um tipo válido!',
            'categoria_id.required' => 'O campo de categoria é obrigatório!',
            'categoria_id' => 'Código de categoria inválido!',
        ];
    }
}
