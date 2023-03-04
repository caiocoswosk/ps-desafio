<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriaRequest extends FormRequest
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
            'categoria' => ['required', 'min:3', 'max:100']
        ];
    }

    public function messages(){
        return [
            'categoria.required' => 'Esse campo é obrigatório!',
            'categoria.min' => 'A categoria deve conter no mínimo 3 caracteres!',
            'categoria.max' => 'A categoria deve conter no máximo 100 caracteres!',
        ];
    }
}
