@extends('adminlte::page')

@section('title', 'Reporte de Ingresos')

@section('content_header')
    <h1 class="text-secondary fs-5 shadow-lg p-2 mb-5 bg-body rounded text-center">Reporte de Ingresos</h1>
@stop

@section('content')
    <div class="container">
        <form action="{{route('storereporting')}}" method="POST">
            @csrf 
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">Ingrese la fecha a consultar</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="fechaDesde" class="form-label">Desde:</label>
                        @if($errors->first('fechaDesde'))
                            <p class="text-danger">{{$errors->first('fechaDesde')}}</p>
                        @endif
                        <input type="date" class="form-control" id="fechaDesde" name="fechaDesde">
                    </div>
                    <div class="mb-3">
                        <label for="fechaHasta" class="form-label">Hasta:</label>
                        @if($errors->first('fechaHasta'))
                            <p class="text-danger">{{$errors->first('fechaHasta')}}</p>
                        @endif
                        <input type="date" class="form-control" id="fechaHasta" name="fechaHasta">
                    </div>
                    <div class="mb-3">
                        <a href="{{route('home')}}">
                            <button type="button" class="btn btn-secondary">Cancelar</button>
                        </a>
                        
                        <button type="submit" class="btn btn-primary">Aceptar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop