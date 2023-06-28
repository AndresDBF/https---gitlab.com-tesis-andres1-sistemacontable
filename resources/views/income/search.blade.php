@extends('adminlte::page')

@section('title', 'Ingreso')

@section('content_header')
    <h1>Creación de Ingreso</h1>
@stop

@section('content')
<div class="container">
    @if(Session::has('error'))
    <div class="alert alert-danger">{{Session::get('error')}}</div>
    @endif
    @if(session('mensaje'))
    <div class="alert alert-success" role="alert">
        {{ session('mensaje') }}
    </div>
    @endif
    <div class="card">
        <div class="card-body pl-6">
            <h3 class="text-center fw-bolder pb-4">Selecciona el Cliente para Facturar</h3>
            <form action="{{route('findIncome')}}" method="POST">
                @csrf
                <div class="well">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-label">
                                <label for="dni">Selección de Cliente</label>
                                <select name="customer" class="custom-select">
                                    @foreach ($customer as $cli)
                                        <option value="{{$cli->identificacion}}">{{$cli->nombre}} / {{$cli->tipid}}-{{$cli->identificacion}}-{{$cli->tiprif}} / {{$cli->email}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                            <a href="/home" class="btn btn-secondary" tabindex="5"><i class="fas fa-home"></i></a>
                            <button type="submit" class="btn btn-primary" tabindex="6"><i class="fas fa-check"></i></button>
                        </div> 
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

