@extends('adminlte::page')

@section('title', 'Emitir NFS-e')

@section('content_header')

@include('includes.alerts')

@endsection

@section('content')

<h3>Dados do(s) Serviço(s)</h3>

<form id="" action="{{ route('prestador.nfse.emissao.terceiraetapa')}}" class="form" method="post">
@csrf
    <input type="hidden" name="dados" value="{{json_encode($dados)}}">
<div id="card-servico" class="card">
    <div class="card-body">  

        <!-- primeira linha -->
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>CNAE</label>
                    <select name="cnaes" id="cnaes" class="form-control">
                        @foreach ($cnaes as $cnae)
                            <option value="{{ $cnae->cnae_id}}"> {{$cnae->codigo . " - " . $cnae->descricao}} </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Atividade</label>
                    <select name="atividades" id="atividades" class="form-control">
                        @foreach ($atividades as $atividade)
                            <option value="{{ $atividade->atividades_id}}"> {{$atividade->codigo . " - " . $atividade->descricao}} </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <!-- fim primeira linha -->

        <!-- segunda linha -->
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Descrição</label>
                    <textarea name="descricao" id="descricao" rows="1" class="form-control"></textarea>
                </div>
            </div>
        </div>
        <!-- fim segunda linha -->


        <!-- terceira linha -->
        <div class="row">
            <div class="col-sm-2">
                <div class="form-group">
                    <label>Valor do Serviço (R$)</label>
                    <input type="text" name="valor" id="valor" class="form-control" value="{{old('valor')}}">
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label>Deduções (R$)</label>
                    <input type="text" name="deducoes" id="deducoes" class="form-control" value="{{old('deducoes')}}">
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label>Desconto Condicionado (R$)</label>
                    <input type="text" name="descontocondicionado" id="descontocondicionado" class="form-control" value="{{old('descontocondicionado')}}">
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label>Desconto Incondicionado (R$)</label>
                    <input type="text" name="descontoincondicionado" id="descontoincondicionado" class="form-control" value="{{old('descontoincondicionado')}}">
                </div>
            </div>
            <div class="col-sm-1">
                <div class="form-group">
                    <label>Alíquota (%)</label>
                    <input type="text" name="aliquota" id="aliquota" class="form-control" value="{{old('aliquota')}}">
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Exigibilidade de ISS Variável</label>
                    <select name="exigibilidadeissvariavel" id="exigibilidadeissvariavel" class="form-control">
                        <option value="EXIGÍVEL">Exigível</option>
                        <option value="NÃO INCIDÊNCIA">Não Incidência</option>
                        <option value="ISENÇÃO">Isenção</option>
                        <option value="IMUNIDADE">Imunidade</option>
                        <option value="EXIGIBILIDADE SUSPENSA POR DECISÃO JUDICIAL">Suspensa por Decisão Judicial</option>
                        <option value="EXIGIBILIDADE SUSPENSA POR PROCESSO ADMINISTRATIVO">Suspensa por Processo Administrativo</option>
                    </select>
                </div>
            </div>
        </div>
        <!-- fim terceira linha -->

        <!-- quarta linha -->
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Total de ISS (R$)</label>
                    <input type="text" name="valoraproximadotributos" id="valoraproximadotributos" class="form-control" value="{{old('valoraproximadotributos')}}">
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label>COFINS (%)</label>
                    <input type="text" name="cofins" id="cofins" class="form-control" value="{{old('cofins')}}">
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label>CSLL (%)</label>
                    <input type="text" name="csll" id="csll" class="form-control" value="{{old('csll')}}">
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label>PIS (%)</label>
                    <input type="text" name="pis" id="pis" class="form-control" value="{{old('pis')}}">
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label>IR (%)</label>
                    <input type="text" name="ir" id="ir" class="form-control" value="{{old('ir')}}">
                </div>
            </div>
        </div>
        <!-- fim quarta linha -->

    </div>
</div>

<div id="card-dinamico" class="card-dinamico">
</div>


<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6" style="text-align: center;">
                <button id="addServico" class="btn btn-info" >
                    <i class="fas fa-plus"></i>
                    Incluir outro(s) Serviço(s) 
                </button>
            </div>
            <div class="col-sm-6" style="text-align: center;">
                <button onClick="history.go(0)" id="excluirServico" class="btn btn-danger">
                    <i class="fas fa-trash"></i>
                    Excluir Serviço(s) 
                </button>
            </div>
        </div>
    </div>
</div>



<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6" style="text-align: center;">
                <button id="voltar" title="Voltar" class="btn btn-success"><i class="fas fa-chevron-left"></i> Voltar</a>
            </div>
            <div class="col-sm-6" style="text-align: center;">
                <button type="submit" class="btn btn-success">
                    Avançar 
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>

</form>

<!--
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12" style="text-align: center;">
                <button id="btnTeste" onclick="insereServico()" class="btn btn-success" style="width: 50%;">
                    Teste 
                </button>
            </div>
        </div>
    </div>
</div> -->

@endsection

@section('plugins.Datatables', true)

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('js')
<script src="{{asset('js/custom.js')}}"></script>
<script>
    $i = 1;
    $("#addServico").click(function(e) {
        $i++;
        e.preventDefault();
        
        var $clone = $("#card-servico").clone();
        
        $clone.find("*[id]").each(function () {
            $(this).attr("id", $(this).attr("id") + "_" + $i);
        });

        $clone.find("*[name]").each(function () {
            $(this).attr("name", $(this).attr("name") + "_" + $i);
        });

        $("#card-dinamico").append($clone);
        $("#card-dinamico").prepend();                       
    });

    $("#excluirServico").click(function(e) {
        e.preventDefault();
        $(".card-dinamico").detach();
    });

    $("#voltar").click(function(e) {
        e.preventDefault();
        window.history.back();
    });
    
</script>
@stop