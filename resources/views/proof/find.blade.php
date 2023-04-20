@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1 class="fw-bolder">Comprobante de Ingreso</h1>
@stop

@section('content')
<div class="container">
    @if(Session::has('error'))
    <div class="alert alert-danger">{{Session::get('error')}}</div>
    @endif
    @if(session('successProof'))
    <div class="alert alert-success" role="alert">
        {{ session('successProof') }}
    </div>
    @endif
    <div class="card">
        <div class="card-body pl-6">
        <h3 class="text-center fw-bolder pb-4">Ingresa la Identificación del Beneficiario de la Factura</h3>
        <form action="{{route('findInvoice')}}" method="POST">
            @csrf
            <div class="well">
                <div class="row">
                    <div class="col-xs-3 col-sm-6 col-md-4">
                        <div class="form-label">
                            <label for="dni">Tipo de Identificación</label>
                            <select name = 'tipid' class="custom-select">
                                <option selected="">Seleccionar Identificación</option>
                                <option value="V">V</option>
                                <option value="J">J</option>
                                <option value="E">E</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-3 col-sm-6 col-md-4">
                        <label for="" class="form-label">Rif o Cedula del Cliente</label>
                        <input type="number" name="identification" id="identification" class="form-control text-decoration-none" tabindex="6">
                    </div>
                    <div class="col-xs-3 col-sm-6 col-md-4">
                        <label for="" class="form-label">Numero de Chequeo</label>
                        <select name = 'numcheck' class="custom-select">
                            <option selected="">Seleccionar Numero</option>
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
  

<div class="well pb-3 mt-3">
  <a href="/home" class="btn btn-secondary" tabindex="5">Cancelar</a>
  <button type="submit" class="btn btn-primary" tabindex="6">Siguiente</button>
</div>  
</form>
@stop