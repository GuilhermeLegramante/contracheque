<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tomador extends Model
{
    protected $fillable = [
        'cpfcnpj', 'razaosocial', 'nomefantasia', 'inscricaomunicipal', 'inscricaoestadual',
        'email', 'telefone', 'cep', 'rua', 'numero', 'bairro', 'cidade', 'uf',
    ];

    protected $table = 'tomadores';

    public function buscaPelaRazaoSocial($pesquisa = null)
    {
        $tomadores = $this->where('razaosocial', 'LIKE', "%{$pesquisa}%")
                            ->orWhere('nomefantasia', 'LIKE', "%{$pesquisa}%")
                            ->paginate(1);
        return $tomadores;
    }
}
