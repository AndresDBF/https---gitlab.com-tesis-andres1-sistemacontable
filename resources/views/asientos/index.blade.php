@extends('adminlte::page')

@section('title', 'Asiento Contable')

@section('content_header')
    <h1 class="text-secondary fs-5 shadow-lg p-2 mb-5 bg-body rounded text-center">Nuevo 
      Asiento</h1>
@stop

@section('content')
  <form action="{{route('asiento')}}" method="POST">
    @csrf
    <div class="well">
      <div class="row">
        <div class="col-xs-3 col-sm-3 col-md-3">
          <label for="" class="form-label">Tipo de Asiento</label>
          <input type="text" name="name" id="name" class="form-control" readonly="readonly" tabindex="2">
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3">
          <label for="" class="form-label">Fecha</label>
          <input type="date" name="identification" id="identification" class="form-control text-decoration-none" tabindex="3">
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3">
          <label for="" class="form-label">Moneda</label>
          <select name="" class="custom-select">
            <option value="">Bolivares</option>
            <option value="">Dolar Estadounidense</option>
            <option value="">Pesos Colombianos</option>
          </select>
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3">
          <label for="" class="form-label">Cambio de Moneda</label>
          <input type="number" name="identification" id="identification" class="form-control text-decoration-none" tabindex="3">
        </div>
      </div>
    </div>
    <br>
    <table id="asiento" class="table table-striped  shadow-lg mt-4" style="width: 100%">

      <thead class="bd-primary text-dark">
          <tr>
              <th scope="col">Cuenta Contable</th>
              <th scope="col">IVA</th>
              <th scope="col">Concepto del Asiento</th>
              <th scope="col">Debe</th>
              <th scope="col">Haber</th>
              <th scope="col">Saldo de Cuenta</th>
          </tr>
      </thead>
      <tbody>
          <tr>
            <td>bancos</td>
            <td>10%</td>
            <td>contrato de cliente</td>
            <td class="bg-body text-dark">100</td>
            <td class="bg-body text-dark">10</td>
          </tr>
      </tbody>
  </table>
  <br>
  <div class="well pb-3">
    <a href="/clientes" class="btn btn-lg btn-secondary" tabindex="5">Cancelar</a>
    <button type="submit" class="btn btn-secondary btn-lg" tabindex="6">Guardar</button>
  </div>
  <br>
  <div class="shadow-lg p-2 mb-5 bg-body rounded">
    <p class="text-secondary text-endfs-6 fw-bolder">Total</p>
  </div>
  </form> 
  
@stop