@extends('adminlte::page')


@section('title', 'Dashboard')

@section('content_header')
<h1>Painel - Fiscal</h1>
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

@stop

@section('content')
{{-- @foreach ($tomadores as $tomador )
<table>
    <tr>
        <td>{{$tomador->nome}}</td>
    </tr>
</table>
@endforeach --}}

@include('flash::message')


@stop

@section('plugins.Datatables', true)

@section('css')

@stop

@section('js')
<script>
    console.log('Hi!');
</script>
@stop