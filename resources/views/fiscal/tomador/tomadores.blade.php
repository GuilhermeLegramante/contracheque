@extends('adminlte::page')


@section('title', 'Tomadores')

@section('content_header')
    <h1>Tomadores</h1><br>

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

<div class="card">
    <div class="card-header">
        <div class="form-group">
            <div class="row">
                <div class="col-sm-8">
                    <div class="form-group">
                        <br>
                        <label>Busca</label>
                        <form action="{{ route('tomador.buscaPelaRazaoSocial') }}" method="POST" class="form form-inline">
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
                            <a href="{{route('tomador.verTodos')}}" class="btn btn-info btn-sm" data-toggle="tooltip" title="Ver Todos"><i class="fas fa-clipboard-list"></i></a>
                            <a href="{{route('tomadores')}}" class="btn btn-success btn-sm" title="Ver Paginação"><i class="fas fa-list"></i></a>
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
                    @foreach ($tomadores as $tomador )
                        <tr>
                            <td>{{$tomador->cpfcnpj}}</td>
                            <td>{{$tomador->razaosocial}}</td>
                            <td>{{$tomador->nomefantasia}}</td>
                            <td>{{$tomador->email}}</td>
                            <td>{{$tomador->telefone}}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('tomador.detalhes', $tomador->id ) }}" class="btn btn-info btn-sm" data-toggle="tooltip" title="Detalhar"><i class="fas fa-info-circle"></i></a>
                                    <a href="{{ route('tomador.edicao', $tomador->id ) }}" class="btn btn-success btn-sm" data-toggle="tooltip" title="Editar"><i class="fas fa-edit"></i></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach 
                </tbody>
            </table>
            
            <div class="d-flex">
                <div class="mx-auto">
                    @if (isset($pesquisa))
                        {!! $tomadores->appends($pesquisa)->links() !!}

                    @else
                        {!! $tomadores->links() !!}
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