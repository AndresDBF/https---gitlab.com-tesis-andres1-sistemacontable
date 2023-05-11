@extends('adminlte::page')

@section('title', 'Proveedores')

@section('content_header')
    <h1 class="text-secondary fs-5 shadow-lg p-2 mb-5 bg-body rounded text-center">Nuevo Proveedor</h1>
@stop

@section('content')
<div class="container"> 
    <div class="card">
      <div class="card-body pl-6">
        <form action="/supplier" method="POST">
          @csrf          
            <div class="mb-3">
              <label for="" class="form-label">Nombre del Proveedor</label>
              @if($errors->first('name'))
                <p class="text-danger">{{$errors->first('name')}}</p>
              @endif
              <input type="text" name="name" id="name" class="form-control" tabindex="2">
            </div>
            <div class="well">
              <div class="row">
                  <div class="col-xs-3 col-sm-6 col-md-4">
                      <div class="form-label">
                          <label for="dni">Tipo de Identificación</label>
                          @if($errors->first('tipid'))
                            <p class="text-danger">{{$errors->first('tipid')}}</p>
                          @endif
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
                      @if($errors->first('identification'))
                        <p class="text-danger">{{$errors->first('identification')}}</p>
                      @endif
                  </div>
                  <div class="col-xs-3 col-sm-6 col-md-4">
                      <label for="" class="form-label">Digito Verificador</label>
                      <select name = 'tiprif' class="custom-select">
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
            
            <div class="mb-3">
              <label for="" class="form-label">Telefono</label>
              @if($errors->first('phone'))
                <p class="text-danger">{{$errors->first('phone')}}</p>
              @endif
              <input type="text" name="phone" id="phone" class="form-control" tabindex="4">
            </div>
            <div class="mb-3">
              <label for="" class="well-lg form-label">Dirección</label>
              @if($errors->first('direction'))
                <p class="text-danger">{{$errors->first('direction')}}</p>
              @endif
              <input type="text" name="direction" id="direction" class="form-control" tabindex="6">
            </div>
            <div class="mb-3">
              <label for="" class="form-label">Correo Electronico</label>
              @if($errors->first('email'))
                <p class="text-danger">{{$errors->first('email')}}</p>
              @endif
              <input type="text" name="email" id="email" class="form-control" tabindex="5">
            </div>
            <div class="form-group">
                <label for="dni">Estatus de Contrato</label>
                <select name = 'stscontr' class="custom-select">
                  <option selected="">Selecciona el Estatus de contrato</option>
                    @foreach ($status as $sts)
                      <option value="{{$sts->sts}}">{{$sts->sts}}</option>
                    @endforeach
                </select>
                @error('stscontr')
                  <div class="alert alert-danger">{{ "Estatus Invalido" }}</div>
                @enderror
            </div>

   
@stop

@section('js')
    <script src="https://kit.fontawesome.com/d2c478c6c0.js" crossorigin="anonymous"></script>
@stop
