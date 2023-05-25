@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="container">
        @if(session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
        @endif
        <div class="card">
            <div class="card-body pl-6">
            <h3 class="text-center fw-bolder pb-4">Ingresa la Identificación del Proveedor</h3>
                <form action="{{route('create')}}" method="POST">
                    @csrf
                    <div class="well">
                        <div class="row">
                            <div class="col-xs-5 col-sm-5 col-md-5">
                                <label for="" class="form-label">Categoria</label>
                                <select name = 'category' id="category" class="custom-select">
                                    <option selected="">Selecciona la Categoria</option>
                                    @foreach ($tipCategory as $tip)
                                    <option value="{{$tip->tip_prove}}">{{$tip->descripcion}}</option>
                                    @endforeach 
                                </select>
                            </div>
                            <div class="col-xs-5 col-sm-5 col-md-5">
                                <label for="" class="form-label">Nombre del Proveedor</label>
                                <select name = 'name' id="name" class="custom-select">
                                    <option selected="">Selecciona el Proveedor</option>
                                    @foreach ($supplier as $sup)
                                        <option value="{{$sup->nombre}}">{{$sup->nombre}}</option>
                                    @endforeach 
                                </select>
                            </div>                        
                        </div>
                    </div>
                    <div class="well pb-3 mt-3">
                        <a href="{{route('reportorder')}}" class="btn btn-secondary" tabindex="5">Atras</a>
                        <button type="submit" class="btn btn-primary" tabindex="6">Aceptar</button>
                    </div> 
                </form>
                
            </div>
        </div>
    </div>
@stop