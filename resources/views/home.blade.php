@extends('adminlte::page')

@section('title', 'Inicio')

@section('content_header')
    <h1 class="text-secondary fs-5 shadow-lg p-2 mb-5 bg-body rounded text-center">Bienvenido {{$user->name}}</h1>
@stop

@section('content')
<div class="container">
    <div class="row" style="font-size: 10px">
        <div class="col-md-12 text-center">
            <div class="position-relative">
                <img src="{{ asset('icons/logocolor.png') }}" alt="Fondo de agua"
                     style="position: absolute; top: 60%; left: 55%; transform: translate(-50%, -10%); width: 50%; height: auto; object-fit: contain; opacity: 0.5;">
            </div>

        </div>
    </div>
</div>

@stop
