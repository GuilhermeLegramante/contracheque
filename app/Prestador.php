<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prestador extends Model
{
    protected $fillable = [
        'cpfcnpj', 'razaosocial', 'nomefantasia', 'inscricaomunicipal', 'inscricaoestadual',
        'email', 'telefone', 'cep', 'rua', 'numero', 'bairro', 'cidade', 'uf',
        'emissaonotafiscal', 'emissaoreciboprovisorio', 'escritorio_id',
        'regimetributario', 'faixasimplesnacional', 'aliquota', 'exigibilidadeissqn',
    ];

    protected $table = 'prestadores';

    public function buscaPelaRazaoSocial($pesquisa = null)
    {
        $prestadores = $this->where('razaosocial', 'LIKE', "%{$pesquisa}%")
                            ->orWhere('nomefantasia', 'LIKE', "%{$pesquisa}%")
                            ->paginate(15);
        return $prestadores;
    }

}
