@extends('adminlte::page')

@section('title', 'Cadastrar Tomador')

@section('content_header')

@include('includes.alerts')

@endsection

@section('content')
<h3 style="margin-top: -20px;">Dados Gerais - Tomador</h3>
<form id="" action="{{ route('tomador.salvar') }}" class="form" method="post">
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
            <div class="col-sm-4">
                <div class="form-group">
                    <label>E-mail</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{old('email')}}">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Telefone</label>
                    <input type="text" name="telefone" id="telefone" class="form-control" value="{{old('telefone')}}">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>CEP</label>
                    <input type="text" name="cep" id="cep" class="form-control" size="10" maxlength="9"
                    onblur="pesquisacep(this.value);" value="{{old('cep')}}">
                </div>
            </div>
        </div>
        <!-- fim segunda linha -->

        <!-- terceira linha -->
        <div class="row">
            <div class="col-sm-6">
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