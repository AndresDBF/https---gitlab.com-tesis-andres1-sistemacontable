@extends('adminlte::page')

@section('title', 'Orden de Compra')

@section('content_header')
    <h1 class="text-secondary fs-5 shadow-lg p-2 mb-5 bg-body rounded text-center">Nueva Orden de Compra</h1>
@stop

@section('content')
<div class="container"> 
  <form action="{{route('storeorder')}}" method="POST">
    <div class="card">
      <div class="card-body pl-6">
          @csrf
            <div class="mb-3">
              <label for="" class="form-label">Numero de Orden</label>
              <input type="numeric" name="numorden" id="numorden" value ="{{$value}}" class="form-control" readonly="readonly">
            </div>
            <div class="mb-3">
              <input type="hidden" value="{{$nameSupplier->idprov}}" name="idprov"> 
              <label for="" class="form-label">Nombre del Proveedor</label>
              <input type="text" name="name" id="name" value ="{{$nameSupplier->nombre}}" class="form-control" readonly="readonly">
            </div>
            <div class="well">
              <div class="row">
                  <div class="col-xs-3 col-sm-6 col-md-4">
                      <div class="form-label">
                          <label for="dni">Tipo de Identificación</label>
                          <input type="text" name="tipid" class="form-control text-decoration-none" value="{{$nameSupplier->tipid}}" readonly="readonly">
                      </div>
                  </div>
                  <div class="col-xs-3 col-sm-6 col-md-4">
                      <label for="" class="form-label">Rif o Cedula del Proveedor</label>
                      <input type="number" name="identification" id="identification" value="{{$nameSupplier->identificacion}}" class="form-control text-decoration-none" readonly="readonly">
                  </div>
                  @if ($nameSupplier->tipid != null)
                    <div class="col-xs-3 col-sm-6 col-md-4" id="div-off">
                      <label for="" class="form-label">Digito Verificador</label>
                      <input type="text" name="tiprif" class="form-control text-decoration-none" value="{{$nameSupplier->tiprif}}" readonly="readonly">
                    </div>
                  @endif
              </div>
            </div>
            <div class="well">
              <div class="row">
                <div class="col-xs-3 col-sm-6 col-md-4">
                  <label for="" class="form-label">Telefono</label>
                  <input type="text" name="phone" id="phone" value="{{$nameSupplier->telefono}}" class="form-control" readonly="readonly">
                </div>
                <div class="col-xs-3 col-sm-6 col-md-4">
                  <label for="dni">Categoria</label>
                  <input type="text" name="category"  class="form-control text-decoration-none" value="{{$nameSupplier->categoria}}" readonly="readonly">
                </div>
                <div class="col-xs-3 col-sm-6 col-md-4">
                  <label for="" class="form-label">Correo Electronico</label>
                  <input type="text" name="email" id="email" value="{{$nameSupplier->correo}}" class="form-control" readonly="readonly">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="" class="well-lg form-label">Dirección</label>
              <input type="text" name="direction" id="direction" value="{{$nameSupplier->direccion}}" class="form-control" readonly="readonly">
            </div>

      </div>
    </div>
    <div class="card">
      <div class="card-body pl-6">
        <div class="well">
          <div class="row">
            <div class="col-xs-3 col-sm-6 col-md-4">
              <label for="" class="well-lg form-label">Dias de Plazo de Pago</label>
              <input type="numeric" name="days" id="days"  class="form-control">
            </div>
            <div class="col-xs-6 col-sm-6">
              <label for="dni">Numero Total de Conceptos</label>
              <select name = 'numconcept' class="custom-select">
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                </select>
            </div>
          </div>
        </div>
        <div class="well pb-3 mt-3">
          <a href="{{route('findsupplier')}}" class="btn btn-secondary" tabindex="5">Cancelar</a>
          <button type="submit" class="btn btn-primary" tabindex="6">Siguiente</button>
      </div> 
      </div>
    </div>
  </form>
</div>

@stop

@section('js')

@stop
