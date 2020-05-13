<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nfse extends Model
{
    protected $fillable = [
        'numero', 'serie', 'competencia',
        'dataemissao', 'dataprestacao', 'serie',
        'competencia', 'ano', 'basecalculo', 'total',
        'valoriss', 'valorliquido',
    ];

    protected $table = 'notasfiscais';
}
