@extends('adminlte::page')

@section('title', 'hsContracheque - Painel')

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

@endsection

@section('content')
<div style="margin-top: -20px; " class="card">
    <div class="card-body">
        <!-- primeira linha -->
        <div style="margin-bottom: -20px;" class="row">
            <div style="" class="col-sm-1 left">
                <div class="form-group left">
                    <label style="font-weight: 600; margin-bottom: -5px;">Inscrição</label>
                    <h5 style="font-weight: 300;">{{ session('inscricao') }}</h5>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label style="font-weight: 600; margin-bottom: -5px;">Nome</label>
                    <h5 style="font-weight: 300;">{{session('nome')}}</h5>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label style="font-weight: 600; margin-bottom: -5px;">CPF</label>
                    <h5 style="font-weight: 300;">{{session('documento')}}</h5>
                </div>
            </div>
        </div>
        <!-- fim primeira linha -->
    </div>
</div>
<div class="card">
    <div class="card-body">
        <h4 style="color: gray; font-weight: 100;"> Dados do Exercício Corrente </h4>
        <hr>

        <div class="row" style="">
            <div class="col-sm-4">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3 style="font-weight: 100; margin-bottom:-3px;">
                            {{number_format(session('valor_provento'), 2, ',', '.')}}</h3>
                        <p>Proventos Exercício</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3 style="font-weight: 100; margin-bottom:-3px;">
                            {{number_format(session('valor_desconto'), 2, ',', '.')}}</h3>
                        <p>Descontos Exercício</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="small-box bg-blue">
                    <div class="inner">
                        <h3 style="font-weight: 100; margin-bottom:-3px;">
                            {{number_format(session('valor_liquido'), 2, ',', '.')}}
                        </h3>
                        <p>Líquido Exercício</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
<p style="font-size: 15px; text-align:center; color: gray; margin-top: 300px; ">Desenvolvido por HardSoft Informática &copy; - Todos os direitos reservados</p>
@endsection

@section('plugins.Datatables', true)

@section('css')

@stop

@section('js')
<script>
    console.log('Hi!');
</script>
@stop