@extends('adminlte::page')

@section('title', 'Consulta Demonstrativo Mensal')

@section('content_header')

@include('includes.alerts')

@endsection

@section('content')
<h3 style="margin-top: -20px;">Consulta Demonstrativo Mensal</h3>
<form id="" action="{{route('buscaContrachequeMensal')}}" class="form" method="post">
    <div class="card">
        <div class="card-body">
            @csrf
            <!-- primeira linha -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Contratos</label>
                        <select name="contrato" id="contrato" class="form-control">
                            @foreach ($contratos as $contrato)
                            <option value="{{$contrato->id}}">{{$contrato->matricula}} | {{$contrato->desc_funcao}} |
                                {{$contrato->dataadmissao}} | {{$contrato->desc_situacao}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <!-- fim primeira linha -->

            <!-- segunda linha -->
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Tipo de Folha</label>
                        <select name="tipofolha" id="tipofolha" class="form-control">
                            @foreach ($tiposfolha as $tipofolha)
                            <option value="{{$tipofolha->id}}">{{$tipofolha->descricao}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Ano</label>
                        <select name="ano" id="ano" class="form-control">
                            {{ $now = date('Y') }}
                            @for ($i=$now; $i>=1990; $i--)
                            <option value="{{$i}}"> {{$i}} </option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Mês</label>
                        <select name="mes" id="mes" class="form-control">
                            <option value="{{$mesNumero}}"> {{$mesAtual}} </option>
                            @foreach ($meses as $key => $mes)
                            <option value="{{$key}}"> {{$mes}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <!-- fim segunda linha -->

        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12" style="text-align: center;">
                    <button type="submit" class="btn btn-success" style="width: 50%;">
                        Consultar
                        <i class="far fa-eye"></i>
                    </button>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-12" style="text-align: center;">
                    <a href="{{ route('painel') }}" style="width: 50%;" title="Voltar" class="btn btn-info"><i class="fas fa-chevron-left"></i> Voltar</a>
                </div>
            </div>
        </div>
    </div>
</form>
<hr>
<p style="font-size: 15px; text-align:center; color: gray; margin-top: 280px; ">Desenvolvido por HardSoft Informática &copy; - Todos os direitos reservados</p>

@endsection

@section('plugins.Datatables', true)

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@endsection

@section('js')
<script src="{{asset('js/custom.js')}}"></script>

@stop