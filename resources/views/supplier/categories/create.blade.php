@extends('adminlte::page')

@section('title', 'Crear Categoria')

@section('content_header')
    <h1 class="text-secondary fs-5 shadow-lg p-2 mb-5 bg-body rounded text-center">Nueva Categoria de Proveedor </h1>
@stop

@section('content')

<div class="container">
    @if (session('error'))
        <div class="alert alert-danger">
            {{session('error')}}
        </div>
    @endif
    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    Crear Valor de Pago
                </div>
                <div class="card-body">
                    <form action="/catsupplier" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Abreviatura de Categoria</label>
                            @if($errors->first('abrecat'))
                                <p class="text-danger">{{$errors->first('abrecat')}}</p>
                            @endif
                            <input type="text" class="form-control" id="abrecat" name="abrecat">
                        </div>                        
                        <div class="mb-3">
                            <label for="salary" class="form-label">Nombre de Categoria</label>
                            @if($errors->first('namecat'))
                                <p class="text-danger">{{$errors->first('namecat')}}</p>
                            @endif
                            <input type="text" class="form-control" id="namecat" name="namecat">
                        </div>
                        <a href="/catsupplier">
                            <button type="button" class="btn btn-secondary">Cancelar</button>
                        </a>
                        <button type="submit" class="btn btn-primary">Crear Categoria</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
