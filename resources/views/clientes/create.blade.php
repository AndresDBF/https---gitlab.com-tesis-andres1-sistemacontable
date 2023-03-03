@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')
    <h1>Nuevo Cliente</h1>
@stop

@section('content')
  <form action="/clientes" method="POST">
    @csrf
      <div class="mb-3">
        <label for="" class="form-label">Codigo Cliente</label>
        <input type="text" name="code" id="code" class="form-control" readonly="readonly" value="{{$idsigue}}" tabindex="1">
      </div>
      <div class="mb-3">
        <label for="" class="form-label">Nombre del Cliente</label>
        <input type="text" name="name" id="name" class="form-control" tabindex="2">
      </div>
      <div class="mb-3">
        <label for="" class="form-label">Rif o Cedula del Cliente</label>
        <input type="number" name="identification" id="identification" class="form-control" tabindex="3">
      </div>
      <div class="col-xs-6 col-sm-6 col-md-6">
    
        <div class="form-group">
          <label for="dni">Status de Contrato</label>
          <select name = 'status' class="custom-select">
            <option selected="">Selecciona un Status</option>
            @foreach ($estatus as $status)
            <option value="{{$status->id}}">{{$status->sts}}</option>
            @endforeach
          </select>
        </div>

      </div>
      <div class="mb-3">
        <label for="" class="form-label">Telefono</label>
        <input type="number" name="phone" id="phone" class="form-control" tabindex="4">
      </div>
      <div class="mb-3">
        <label for="" class="form-label">Correo Electronico</label>
        <input type="text" name="email" id="email" class="form-control" tabindex="4">
      </div>
      <div class="mb-3">
        <label for="" class="form-label">Dirección</label>
        <input type="text" name="direction" id="direction" class="form-control" tabindex="4">
      </div>
      <a href="/articulos" class="btn btn-secondary" tabindex="5">Cancelar</a>
      <button type="submit" class="btn btn-primary" tabindex="6">Guardar</button>
    
  </form>
@stop
