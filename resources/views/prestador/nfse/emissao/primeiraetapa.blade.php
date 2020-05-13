@extends('adminlte::page')

@section('title', 'Emitir NFS-e')

@section('content_header')

@include('includes.alerts')

@endsection

@section('content')
<h3 style="margin-top: -20px;">Dados Gerais - NFS-e</h3>
<form id="" action="{{ route('prestador.nfse.emissao.segundaetapa') }}" class="form" method="post">
    <div class="card">
        <div class="card-body">
            @csrf
            <!-- primeira linha -->
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Nº NFS-e</label>
                        <input type="hidden" name="numeronfse" value="{{$numeronfse}}">
                        <input type="text" id="numeronfse" class="form-control"
                            value="{{old('numeronfse') ?? $numeronfse}}" disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Data Emissão</label>
                        <input type="date" name="dataemissao" id="dataemissao" class="form-control"
                            value="{{old('dataemissao')}}" required>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Data Prestação</label>
                        <input type="date" name="dataprestacao" id="dataprestacao" class="form-control"
                            value="{{old('dataprestacao')}}" required>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Local Prestação</label>
                        <input type="text" name="localprestacao" id="localprestacao" class="form-control"
                            value="{{old('localprestacao') ?? $prestador->cidade}}" required>
                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="form-group">
                        <label>Série</label>
                        <select name="serie" id="serie" class="form-control" required>
                            <option value="1">1</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="form-group">
                        <label>Competência</label>
                        <select name="competencia" id="competencia" class="form-control" required>
                            <option value=""></option>
                            <option value="JANEIRO">Jan</option>
                            <option value="FEVEREIRO">Fev</option>
                            <option value="MARÇO">Mar</option>
                            <option value="ABRIL">Abr</option>
                            <option value="MAIO">Mai</option>
                            <option value="JUNHO">Jun</option>
                            <option value="JULHO">Jul</option>
                            <option value="AGOSTO">Ago</option>
                            <option value="SETEMBRO">Set</option>
                            <option value="OUTUBRO">Out</option>
                            <option value="NOVEMBRO">Nov</option>
                            <option value="DEZEMBRO">Dez</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="form-group">
                        <label>Ano</label>
                        <input type="text" name="ano" id="ano" class="form-control" value="{{old('ano') ?? $ano}}"
                            maxlength="4" required>
                    </div>
                </div>
            </div>
            <!-- fim primeira linha -->
        </div>
    </div>

    <h3>Dados do Prestador</h3>
    <div class="card">
        <div class="card-body">
            @csrf
            <!-- primeira linha -->
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>CPF/CNPJ</label>
                        <input type="hidden" name="id" value="{{$prestador->id}}">
                        <input type="text" name="cpfcnpj" id="cpfcnpj" class="form-control"
                            value="{{old('cpfcnpj') ?? $prestador->cpfcnpj}}"
                            onfocus="javascript: retirarFormatacao(this);" onblur="javascript: formatarCampo(this);"
                            maxlength="14" required>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Razão Social</label>
                        <input type="text" name="razaosocial" id="razaosocial" class="form-control"
                            value="{{old('razaosocial') ?? $prestador->razaosocial}}" required>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Nome Fantasia</label>
                        <input type="text" name="nomefantasia" id="nomefantasia" class="form-control"
                            value="{{old('nomefantasia') ?? $prestador->nomefantasia}}">
                    </div>
                </div>
            </div>
            <!-- fim primeira linha -->

            <!-- segunda linha -->
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Inscrição Municipal</label>
                        <input type="text" name="inscricaomunicipal" id="inscricaomunicipal" class="form-control"
                            value="{{old('inscricaomunicipal') ?? $prestador->inscricaomunicipal}}" required>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Inscrição Estadual</label>
                        <input type="text" name="inscricaoestadual" id="inscricaoestadual" class="form-control"
                            value="{{old('inscricaoestadual') ?? $prestador->inscricaoestadual}}">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>E-mail</label>
                        <input type="email" name="email" id="email" class="form-control"
                            value="{{old('email') ?? $prestador->email}}">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Telefone</label>
                        <input type="text" name="telefone" id="telefone" class="form-control"
                            value="{{old('telefone') ?? $prestador->telefone}}">
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
                            onblur="pesquisacep(this.value);" value="{{old('cep') ?? $prestador->cep}}">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Rua</label>
                        <input type="text" name="rua" id="rua" size="60" class="form-control"
                            value="{{old('rua') ?? $prestador->rua}}">
                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="form-group">
                        <label>Número</label>
                        <input type="text" name="numero" id="numero" class="form-control"
                            value="{{old('numero') ?? $prestador->numero}}">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Bairro</label>
                        <input type="text" name="bairro" id="bairro" size="40" class="form-control"
                            value="{{old('bairro') ?? $prestador->bairro}}">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Cidade</label>
                        <input type="text" name="cidade" id="cidade" size="40" class="form-control"
                            value="{{old('cidade') ?? $prestador->cidade}}">
                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="form-group">
                        <label>UF</label>
                        <input type="text" name="uf" id="uf" size="2" class="form-control"
                            value="{{old('uf') ?? $prestador->uf}}">
                    </div>
                </div>
            </div>
            <!-- fim terceira linha -->
        </div>
    </div>



    <h3>Dados do Tomador</h3>
    <div class="card">
        <div class="card-body">
            @csrf
            <!-- primeira linha -->
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>CPF/CNPJ</label>
                        <input type="text" name="cpfcnpjtomador" id="cpfcnpj" class="form-control"
                            value="{{old('cpfcnpj')}}" onfocus="javascript: retirarFormatacao(this);"
                            onblur="javascript: formatarCampo(this);" maxlength="14" required>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Razão Social</label>
                        <input type="text" name="razaosocialtomador" id="razaosocial" class="form-control"
                            value="{{old('razaosocial')}}" required>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Nome Fantasia</label>
                        <input type="text" name="nomefantasiatomador" id="nomefantasia" class="form-control"
                            value="{{old('nomefantasia')}}">
                    </div>
                </div>
            </div>
            <!-- fim primeira linha -->

            <!-- segunda linha -->
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>E-mail</label>
                        <input type="email" name="emailtomador" id="email" class="form-control"
                            value="{{old('email')}}">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Telefone</label>
                        <input type="text" name="telefonetomador" id="telefone" class="form-control"
                            value="{{old('telefone')}}">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>CEP</label>
                        <input type="text" name="ceptomador" id="cep" class="form-control" size="10" maxlength="9"
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
                        <input type="text" name="ruatomador" id="rua" size="60" class="form-control"
                            value="{{old('rua')}}">
                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="form-group">
                        <label>Número</label>
                        <input type="text" name="numerotomador" id="numero" class="form-control"
                            value="{{old('numero')}}">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Bairro</label>
                        <input type="text" name="bairrotomador" id="bairro" size="40" class="form-control"
                            value="{{old('bairro')}}">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Cidade</label>
                        <input type="text" name="cidadetomador" id="cidade" size="40" class="form-control"
                            value="{{old('cidade')}}">
                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="form-group">
                        <label>UF</label>
                        <input type="text" name="uftomador" id="uf" size="2" class="form-control" value="{{old('uf')}}">
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
                        Avançar
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

</form>


@endsection

@section('plugins.Datatables', true)

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('js')
<script src="{{asset('js/custom.js')}}"></script>
@stop