@extends('adminlte::page')

@section('title', 'Painel')

@section('content_header')
<h1>Painel - Munícipe</h1>
<br>

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

<h3>teste</h3>

@endsection

@section('plugins.Datatables', true)

@section('css')

@stop

@section('js')
<script>
    console.log('Hi!');
</script>
@stop
