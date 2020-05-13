<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CriaAlteraTomador extends FormRequest
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
            'cpfcnpj' => 'required|unique:tomadores,cpfcnpj',
            'razaosocial' => 'required|unique:tomadores,razaosocial',
            'nomefantasia' => 'nullable',
            'email' => 'required', 
            'telefone' => 'required',
            'cep' => 'nullable',
            'rua' => 'nullable',
            'bairro' => 'nullable',
            'cidade' => 'nullable',
            'uf' => 'nullable',
        ];
    }
}
