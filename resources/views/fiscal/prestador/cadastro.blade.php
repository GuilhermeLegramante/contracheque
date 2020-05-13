@extends('adminlte::page')

@section('title', 'Cadastrar Prestador')

@section('content_header')

@include('includes.alerts')

@endsection

@section('content')
<h3 style="margin-top: -20px;">Dados Gerais - Prestador</h3>
<form id="" action="{{ route('prestador.salvar') }}" class="form" method="post">
<div class="card">
    <div class="card-body">  
        @csrf
        <!-- primeira linha -->
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label>CPF/CNPJ</label>
                    <input type="text" name="cpfcnpj" id="cpfcnpj" class="form-control" value="{{old('cpfcnpj')}}" onfocus="javascript: retirarFormatacao(this);" onblur="javascript: formatarCampo(this);" maxlength="14">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Razão Social</label>
                    <input type="text" name="razaosocial" id="razaosocial" class="form-control" value="{{old('razaosocial')}}">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Nome Fantasia</label>
                    <input type="text" name="nomefantasia" id="nomefantasia" class="form-control" value="{{old('nomefantasia')}}">
                </div>
            </div>
        </div>
        <!-- fim primeira linha -->

        <!-- segunda linha -->
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Inscrição Municipal</label>
                    <input type="text" name="inscricaomunicipal" id="inscricaomunicipal" class="form-control" value="{{old('inscricaomunicipal')}}">
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Inscrição Estadual</label>
                    <input type="text" name="inscricaoestadual" id="inscricaoestadual" class="form-control" value="{{old('inscricaoestadual')}}">
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>E-mail</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{old('email')}}">
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Telefone</label>
                    <input type="text" name="telefone" id="telefone" class="form-control" value="{{old('telefone')}}">
                </div>
            </div>
        </div>
        <!-- fim segunda linha -->

        <!-- terceira linha -->
        <div class="row">
            <div class="col-sm-2">
                <div class="form-group">
                    <label>CEP</label>
                    <input type="text" name="cep" id="cep" class="form-control" size="10" maxlength="9"
                    onblur="pesquisacep(this.value);" value="{{old('cep')}}">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Rua</label>
                    <input type="text" name="rua" id="rua" size="60" class="form-control" value="{{old('rua')}}">
                </div>
            </div>
            <div class="col-sm-1">
                <div class="form-group">
                    <label>Número</label>
                    <input type="text" name="numero" id="numero" class="form-control" value="{{old('numero')}}">
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label>Bairro</label>
                    <input type="text" name="bairro" id="bairro" size="40" class="form-control" value="{{old('bairro')}}">
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label>Cidade</label>
                    <input type="text" name="cidade" id="cidade" size="40" class="form-control" value="{{old('cidade')}}">
                </div>
            </div>
            <div class="col-sm-1">
                <div class="form-group">
                    <label>UF</label>
                    <input type="text" name="uf" id="uf" size="2" class="form-control" value="{{old('uf')}}">
                </div>
            </div>
        </div>
        <!-- fim terceira linha -->  
    </div>
</div>

<h3>Informações Adicionais</h3>

<div class="card">
    <div class="card-body">
        <!-- primeira linha -->
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Escritório de Contabilidade</label>
                    <select name="escritorio_id" id="escritorio_id" class="form-control">
                        @foreach ($escritorios as $escritorio)
                            <option value="{{ $escritorio->id}}"> {{$escritorio->razaosocial}} </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <!-- fim primeira linha -->
        <!-- primeira linha -->
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Regime Tributário</label>
                    <select onchange="desabilitaSelect(this)" name="regimetributario" id="regimetributario" class="form-control">
                        <option value="Simples Nacional">Simples Nacional</option>
                        <option value="Lucro Presumido">Lucro Presumido</option>
                        <option value="Lucro Real">Lucro Real</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Faixa do Simples Nacional</label>
                    <select name="faixasimplesnacional" id="faixasimplesnacional" class="form-control">
                        <option value="1">Até R$ 180.000,00</option>
                        <option value="2">De R$ 180.000,01 a R$ 360.000,00</option>
                        <option value="3">De R$ 360.000,01 a R$ 720.000,00</option>
                        <option value="4">De R$ 720.000,01 a R$ 1.800.000,00</option>
                        <option value="5">De R$ 1.800.000,01 a R$ R$ 3.600.000,00</option>
                        <option value="6">De R$ 3.600.000,01 a R$ 4.800.000,00</option>
                        <option value=""></option>
                    </select>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Alíquota (%)</label>
                    <input type="text" name="aliquota" id="aliquota" class="form-control" maxlength="4" value="{{old('aliquota')}}">
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Exigibilidade ISSQN</label>
                    <select name="exigibilidadeissqn" id="exigibilidadeissqn" class="form-control">
                        <option value="Sim">Sim</option>
                        <option value="Não">Não</option>
                    </select>
                </div>
            </div>
        </div>
        <!-- fim primeira linha -->

        <!-- segunda linha -->
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Emissão de Nota Fiscal</label>
                    <select name="emissaonotafiscal" id="emissaonotafiscal" class="form-control">
                        <option value="Não">Não</option>
                        <option value="Sim">Sim</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Emissão de Recibo Provisório</label>
                    <select name="emissaoreciboprovisorio" id="emissaoreciboprovisorio" class="form-control">
                        <option value="Não">Não</option>
                        <option value="Sim">Sim</option>
                    </select>
                </div>
            </div>
        </div>
        <!-- fim segunda linha -->

        <!-- terceira linha -->
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label>CNAE(s)</label>&nbsp;<i data-toggle="tooltip" title="Segure CTRL para selecionar mais de um CNAE." class="fas fa-question-circle"></i></a>
                    <select multiple name="cnaes[]" id="cnaes" class="form-control">
                        @foreach ($cnaes as $cnae)
                            <option value="{{ $cnae->id}}"> {{$cnae->codigo . " - " . $cnae->descricao}} </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <!-- fim terceira linha -->

        <!-- quarta linha -->
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Atividade(s)</label>&nbsp;<i data-toggle="tooltip" title="Segure CTRL para selecionar mais de uma Atividade." class="fas fa-question-circle"></i></a>
                    <select multiple name="atividades[]" id="atividades" class="form-control">
                        @foreach ($atividades as $atividade)
                            <option value="{{ $atividade->id}}"> {{$atividade->codigo . " - " . $atividade->descricao}} </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <!-- fim quarta linha -->
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12" style="text-align: center;">
                <button type="submit" class="btn btn-success" style="width: 50%;">
                    Cadastrar 
                    <i class="fas fa-save"></i>
                </button>
            </div>
        </div>
    </div>
</div>

</form>
@stop

@section('plugins.Datatables', true)

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('js')
<script src="{{asset('js/custom.js')}}"></script>

@stop