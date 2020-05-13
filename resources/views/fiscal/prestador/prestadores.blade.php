@extends('adminlte::page')


@section('title', 'Prestadores')

@section('content_header')
<h1>Prestadores</h1><br>

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

<div class="card">
    <div class="card-header">
        <div class="form-group">
            <div class="row">
                <div class="col-sm-8">
                    <div class="form-group">
                        <br>
                        <label>Busca</label>
                        <form action="{{ route('prestador.buscaPelaRazaoSocial') }}" method="POST" class="form form-inline">
                            @csrf
                        <input style="height: 70%; width: 40%; margin-right: 1%;" type="text" name="pesquisa" id="pesquisa" title="Razão Social ou Nome Fantasia" placeholder="Razão Social ou Nome Fantasia" class="form-control" value="{{ $pesquisa['pesquisa'] ?? '' }}">
                        <button type="submit" class="btn btn-dark btn-sm " title="Pesquisar"><i class="fas fa-search"></i></button>
                        </form>
                    </div>  
                </div>
                
                <div class="col-sm-4" style="margin-top: 2.6%; margin-left: -450px; padding-right: 1px; width: 120%;">
                    <div class="form-group">
                        <br>
                        <div class="btn-group" role="group">
                            <a href="{{route('prestador.verTodos')}}" class="btn btn-info btn-sm" data-toggle="tooltip" title="Ver Todos"><i class="fas fa-clipboard-list"></i></a>
                            <a href="{{route('prestadores')}}" class="btn btn-success btn-sm" title="Ver Paginação"><i class="fas fa-list"></i></a>
                        </div>
                    </div>   
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>CPF/CNPJ</th>
                        <th>Razão Social</th>
                        <th>Nome Fantasia</th>
                        <th>E-mail</th>
                        <th>Telefone</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($prestadores as $prestador )
                        <tr>
                            <td>{{$prestador->cpfcnpj}}</td>
                            <td>{{$prestador->razaosocial}}</td>
                            <td>{{$prestador->nomefantasia}}</td>
                            <td>{{$prestador->email}}</td>
                            <td>{{$prestador->telefone}}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('prestador.detalhes', $prestador->id ) }}" class="btn btn-info btn-sm" data-toggle="tooltip" title="Detalhar"><i class="fas fa-info-circle"></i></a>
                                    <a href="{{ route('prestador.edicao', $prestador->id ) }}" class="btn btn-success btn-sm" data-toggle="tooltip" title="Editar"><i class="fas fa-edit"></i></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach 
                </tbody>
            </table>
            
            <div class="d-flex">
                <div class="mx-auto">
                    @if (isset($pesquisa))
                        {!! $prestadores->appends($pesquisa)->links() !!}

                    @else
                        {!! $prestadores->links() !!}
                    @endif
                    
                </div>
            </div>
        </div>
    </div>

</div>




@stop

@section('plugins.Datatables', true)

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('js')
<script src="{{asset('js/custom.js')}}"></script>
@stop