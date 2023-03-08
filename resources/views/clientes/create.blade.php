@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')
    <h1 class="text-secondary fs-5 shadow-lg p-2 mb-5 bg-body rounded text-center">Nuevo Cliente</h1>
@stop

@section('content')
  <form action="/clientes" method="POST">
    @csrf
      <div class="mb-3">
        <label for="" class="form-label">Codigo Cliente</label>
        <input type="text" name="code" id="code" class="form-control" readonly="readonly" value="{{$idsigue}}" tabindex="1">
      </div>
      <div class="well">
        <div class="row">
          <div class="col-xs-3 col-sm-6 col-md-6">
            <label for="" class="form-label">Nombre del Cliente</label>
            <input type="text" name="name" id="name" class="form-control" tabindex="2">
          </div>
          <div class="col-xs-3 col-sm-6 col-md-4">
            <label for="" class="form-label">Rif o Cedula del Cliente</label>
            <input type="number" name="identification" id="identification" class="form-control text-decoration-none" tabindex="3">
          </div>
        </div>
      </div>
      
      <div class="mb-3">
        <label for="" class="form-label">Telefono</label>
        <input type="text" name="phone" id="phone" class="form-control" tabindex="4">
      </div>
      <div class="mb-3">
        <label for="" class="form-label">Correo Electronico</label>
        <input type="text" name="email" id="email" class="form-control" tabindex="5">
      </div>
      <div class="mb-3">
        <label for="" class="well-lg form-label">Dirección</label>
        <input type="text" name="direction" id="direction" class="form-control" tabindex="6">
      </div>
      <br>

      <h1 class="pb-6">Contrato del Cliente</h1>
      <div class="well">
        <div class="row">
          <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
              <label for="dni">Estatus de Contrato</label>
              <select name = 'stscontr' class="custom-select">
                <option selected="">Selecciona el Estatus de contrato</option>
                  <option value="ACT">Activo</option>
              </select>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6 col-md-4">
            <div class="form-group">
              <label for="dni">Tipo de Pago</label>
              <select name = 'tip_pag' class="custom-select">
                <option selected="">Selecciona un tipo de pago</option>
                  <option value="Anual">Anual</option>
                  <option value="Mensual">Mensual</option>
                  <option value="Semestral">Semestral</option>
                  <option value="Trimestral">Trimestral</option>
              </select>
            </div>
          </div>
        </div>
        <div class="well">
          <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
              <label for="" class="form-label">Monto del Contrato</label>
              <input type="number" name="valuecont" id="valuecont" class="form-control" tabindex="7">
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
              <div class="form-group">
                <label for="dni">Moneda</label>
                <select name = 'money' class="custom-select">
                  <option selected="">Selecciona una Moneda</option>
                    <option value="BOL">Bolivares</option>
                    <option value="USD">Dolares</option>
                    <option value="COP">Pesos</option>
                </select>
              </div>
            </div>
          </div>
        </div>
        
          <div class="form-group">
            <label for="dni">Tipo de Cuenta</label>
            <select name = 'account' class="custom-select">
                <option selected="">Selecciona una cuenta</option>
                @foreach ($accounts as $account)
                    <option value="{{$account->idcta}}">{{$account->tipcta}}</option>
                @endforeach
            </select>
          </div>

          <div class="form-group" {{ action('ControllerName', ['id'=>1]) }}>
            <label for="dni">Tipo de Movimiento </label>
            <select name = 'account' class="custom-select">
                <option selected="">Selecciona una movimiento</option>
                @foreach ($accounts as $account)
                    <option value="{{$account->idcta}}">      
                      <p class="ms-2">/ {{$account->tipmov}}</p>
                    </option>
                @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="dni">Nombre de Cuenta</label>
            <select name = 'account' class="custom-select">
                <option selected="">Selecciona Nonbre de Cuenta</option>
                @foreach ($accounts as $account)
                    <option value="{{$account->idcta}}">
                      <p class="row aling-items-start">{{$account->tipcta}}</p>
                      <p class="ms-2">/ {{$account->tipmov}}</p>
                      <p class="ms-4">/ {{$account->nombre_cuenta}}</p>
                    </option>
                @endforeach
            </select>
          </div>
          
      </div>
      <div class="well pb-3">
        <a href="/clientes" class="btn btn-secondary" tabindex="5">Cancelar</a>
        <button type="submit" class="btn btn-primary" tabindex="6">Guardar</button>
      </div>  
  </form> 
  
@stop
