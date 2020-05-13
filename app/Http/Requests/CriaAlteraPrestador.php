<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CriaAlteraPrestador extends FormRequest
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
            'cpfcnpj' => 'required|unique:prestadores,cpfcnpj',
            'razaosocial' => 'required|unique:prestadores,razaosocial',
            'nomefantasia' => 'nullable',
            'inscricaomunicipal' => 'required|unique:prestadores,inscricaomunicipal',
            'inscricaoestadual' => 'nullable',
            'email' => 'required', 
            'telefone' => 'required',
            'cep' => 'required',
            'rua' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'uf' => 'required',
            'numero' => 'required',
            'faixasimplesnacional' => 'nullable',
            'aliquota' => 'required',
        ];
    }
}
