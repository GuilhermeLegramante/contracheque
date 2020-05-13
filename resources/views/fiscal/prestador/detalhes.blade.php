@extends('adminlte::page')


@section('title', 'Detalhes Prestador')

@section('content_header')


@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
 
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@stop

@section('content')

<h3 style="margin-top: -20px;">Dados Gerais - Prestador</h3>
<div class="card">
    <div class="card-body">  
        @csrf
        <!-- primeira linha -->
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label>CPF/CNPJ</label>
                <input type="text" name="cpfcnpj" id="cpfcnpj" class="form-control" value="{{ $prestador->cpfcnpj }}" disabled>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Razão Social</label>
                    <input type="text" name="razaosocial" id="razaosocial" class="form-control" value="{{ $prestador->razaosocial }}" disabled>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Nome Fantasia</label>
                    <input type="text" name="nomefantasia" id="nomefantasia" class="form-control" value="{{ $prestador->nomefantasia }}" disabled>
                </div>
            </div>
        </div>
        <!-- fim primeira linha -->

        <!-- segunda linha -->
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Inscrição Municipal</label>
                    <input type="text" name="inscricaomunicipal" id="inscricaomunicipal" class="form-control" value="{{ $prestador->inscricaomunicipal }}" disabled>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Inscrição Estadual</label>
                    <input type="text" name="inscricaoestadual" id="inscricaoestadual" class="form-control" value="{{ $prestador->inscricaoestadual }}" disabled>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>E-mail</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ $prestador->email }}" disabled>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Telefone</label>
                    <input type="text" name="telefone" id="telefone" class="form-control" value="{{ $prestador->telefone }}" disabled>
                </div>
            </div>
        </div>
        <!-- fim segunda linha -->

        <!-- terceira linha -->
        <div class="row">
            <div class="col-sm-2">
                <div class="form-group">
                    <label>CEP</label>
                    <input type="text" name="cep" id="cep" class="form-control" value="{{ $prestador->cep }}" disabled>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Rua</label>
                    <input type="text" name="rua" id="rua" size="60" class="form-control" value="{{ $prestador->rua }}" disabled>
                </div>
            </div>
            <div class="col-sm-1">
                <div class="form-group">
                    <label>Número</label>
                    <input type="text" name="numero" id="numero" class="form-control" value="{{ $prestador->numero }}" disabled>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label>Bairro</label>
                    <input type="text" name="bairro" id="bairro" size="40" class="form-control" value="{{ $prestador->bairro }}" disabled>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label>Cidade</label>
                    <input type="text" name="cidade" id="cidade" size="40" class="form-control" value="{{ $prestador->cidade }}" disabled>
                </div>
            </div>
            <div class="col-sm-1">
                <div class="form-group">
                    <label>UF</label>
                    <input type="text" name="uf" id="uf" size="2" class="form-control" value="{{ $prestador->uf }}" disabled>
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
                    <input type="text" name="escritorio" id="escritorio" class="form-control" value="{{ $escritorio->razaosocial }}" disabled>
                </div>
            </div>
        </div>
        <!-- fim primeira linha -->
        <!-- primeira linha -->
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Regime Tributário</label>
                    <input type="text" name="regimetributario" id="regimetributario" class="form-control" value="{{ $prestador->regimetributario }}" disabled>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Faixa do Simples Nacional</label>
                    @if ($prestador->faixasimplesnacional == '')
                        <input type="text" name="faixasimplesnacional" id="faixasimplesnacional" class="form-control" value="" disabled>
                    @endif
                    @if ($prestador->faixasimplesnacional == '1')
                        <input type="text" name="faixasimplesnacional" id="faixasimplesnacional" class="form-control" value="Até R$ 180.000,00" disabled>
                    @endif
                    @if ($prestador->faixasimplesnacional == '2')
                        <input type="text" name="faixasimplesnacional" id="faixasimplesnacional" class="form-control" value="De R$ 180.000,01 a R$ 360.000,00" disabled>
                    @endif
                    @if ($prestador->faixasimplesnacional == '3')
                        <input type="text" name="faixasimplesnacional" id="faixasimplesnacional" class="form-control" value="De R$ 360.000,01 a R$ 720.000,00" disabled>
                    @endif
                    @if ($prestador->faixasimplesnacional == '4')
                        <input type="text" name="faixasimplesnacional" id="faixasimplesnacional" class="form-control" value="De R$ 720.000,01 a R$ 1.800.000,00" disabled>
                    @endif
                    @if ($prestador->faixasimplesnacional == '5')
                        <input type="text" name="faixasimplesnacional" id="faixasimplesnacional" class="form-control" value="De R$ 1.800.000,01 a R$ R$ 3.600.000,00" disabled>
                    @endif
                    @if ($prestador->faixasimplesnacional == '6')
                        <input type="text" name="faixasimplesnacional" id="faixasimplesnacional" class="form-control" value="De R$ 3.600.000,01 a R$ 4.800.000,00" disabled>
                    @endif
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Alíquota (%)</label>
                    <input type="text" name="aliquota" id="aliquota" class="form-control" value="{{ $prestador->aliquota }}" disabled>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Exigibilidade ISSQN</label>
                    <input type="text" name="exigibilidadeissqn" id="exigibilidadeissqn" class="form-control" value="{{ $prestador->exigibilidadeissqn }}" disabled>
                </div>
            </div>
        </div>
        <!-- fim primeira linha -->

        <!-- segunda linha -->
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Emissão de Nota Fiscal</label>
                    <input type="text" name="emissaonotafiscal" id="emissaonotafiscal" class="form-control" value="{{ $prestador->emissaonotafiscal }}" disabled>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Emissão de Recibo Provisório</label>
                    <input type="text" name="emissaoreciboprovisorio" id="emissaoreciboprovisorio" class="form-control" value="{{ $prestador->emissaoreciboprovisorio }}" disabled>
                </div>
            </div>
        </div>
        <!-- fim segunda linha -->

        <!-- terceira linha -->
        <div class="row">
            <div class="col-sm-12" style="text-align: left;">
                <div class="form-group">
                    <label>CNAE(s)</label>     
                    @foreach($cnaes as $cnae)
                        <h3>
                            {{$cnae->codigo . " - " . $cnae->descricao}}
                        </h3>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- fim terceira linha -->

        <!-- quarta linha -->
        <div class="row">
            <div class="col-sm-12" style="text-align: left;">
                <div class="form-group">
                    <label>Atividade(s)</label>     
                    @foreach($atividades as $atividade)
                        <h3>
                            {{$atividade->codigo . " - " . $atividade->descricao}}
                        </h3>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- fim terceira linha -->

    </div>
</div>


<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-1">
                <a href="{{ url()->previous() }}" title="Voltar"  class="btn btn-info"><i class="fas fa-chevron-left"></i></a>
            </div>
            <div class="col-sm-1">
                <form action="{{ route('prestador.excluir', $prestador->id ) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button title="Excluir Prestador" onclick="return confirm('Deseja mesmo excluir o registro?');" type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('plugins.Datatables', true)

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('js')
<script src="{{asset('js/custom.js')}}"></script>
@stop