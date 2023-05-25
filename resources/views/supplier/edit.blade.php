@extends('adminlte::page')

@section('title', 'Proveedores')

@section('content_header')
    <h1 class="text-secondary fs-5 shadow-lg p-2 mb-5 bg-body rounded text-center">Editar Proveedor</h1>
@stop

@section('content')
<div class="container"> 
    <div class="card">
      <div class="card-body pl-6">
        <form action="/supplier/{{$supplier->idprov}}" method="POST">
          @csrf
          @method('PUT')
            <div class="mb-3">
              <label for="" class="form-label">Nombre del Proveedor</label>
              @if($errors->first('name'))
                <p class="text-danger">{{$errors->first('name')}}</p>
              @endif
              <input type="text" name="name" id="name" value="{{$supplier->nombre}}" class="form-control" tabindex="2">
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
                            @if ($supplier->tipid == 'V')
                                <option value="V">V</option>
                                <option value="J">J</option>
                                <option value="E">E</option>
                            @elseif($supplier->tipid == 'J')
                                <option value="J">J</option>
                                <option value="V">V</option>
                                <option value="E">E</option>
                            @elseif($supplier->tipid == 'E')
                                <option value="E">E</option>
                                <option value="V">V</option>
                                <option value="E">E</option>
                            @else
                                <option selected="">Seleccionar Identificación</option>
                                <option value="V">V</option>
                                <option value="J">J</option>
                                <option value="E">E</option>
                            @endif
                          </select>
                      </div>
                  </div>
                  <div class="col-xs-3 col-sm-6 col-md-4">
                      <label for="" class="form-label">Rif o Cedula del Proveedor</label>
                      <input type="number" name="identification" id="identification" value="{{$supplier->identificacion}}" class="form-control text-decoration-none" tabindex="6">
                      @if($errors->first('identification'))
                        <p class="text-danger">{{$errors->first('identification')}}</p>
                      @endif
                  </div>
                  <div class="col-xs-3 col-sm-6 col-md-4" id="div-off">
                      <label for="" class="form-label">Digito Verificador</label>
                      <select name = 'tiprif' class="custom-select">
                        @if ($supplier->tiprif == null)
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
                        @else
                            @for ($i = 0; $i < 10; $i++)
                                @if ($i == $supplier->tiprif)
                                    <option value="{{$i}}" selected>{{$i}}</option>
                                @endif
                                <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        
                        @endif
                      </select>
                  </div>
              </div>
            </div>
            
            <div class="mb-3">
              <label for="" class="form-label">Telefono</label>
              @if($errors->first('phone'))
                <p class="text-danger">{{$errors->first('phone')}}</p>
              @endif
              <input type="text" name="phone" id="phone" value="{{$supplier->telefono}}" class="form-control" tabindex="4">
            </div>
            <div class="mb-3">
              <label for="" class="well-lg form-label">Dirección</label>
              @if($errors->first('direction'))
                <p class="text-danger">{{$errors->first('direction')}}</p>
              @endif
              <input type="text" name="direction" id="direction" value="{{$supplier->direccion}}" class="form-control" tabindex="6">
            </div>
            <div class="mb-3">
              <label for="" class="form-label">Correo Electronico</label>
              @if($errors->first('email'))
                <p class="text-danger">{{$errors->first('email')}}</p>
              @endif
              <input type="text" name="email" id="email" value="{{$supplier->correo}}" class="form-control" tabindex="5">
            </div>
            <div class="form-group">
                <label for="dni">Categoria</label>
                @if ($errors->first('category'))
                  <p class="text-danger">{{$errors->first('email')}}</p>
                @endif
                <select name = 'category' class="custom-select">
                    @if ($supplier->categoria = null)
                      <option selected="">Selecciona la Categoria</option>
                      @foreach ($tipSupplier as $tip)
                        <option value="{{$tip->tip_prove}}">{{$tip->descripcion}}</option>
                      @endforeach
                    @else
                    <option value="{{$categorySupplier}}">{{$tipCategory}}</option>
                    @foreach ($tipSupplier as $tip)
                      @if ($tip->tip_prove == $categorySupplier)
                        @continue
                      @endif
                      <option value="{{$tip->tip_prove}}">{{$tip->descripcion}}</option>
                    @endforeach
                    @endif
                </select>
            </div>
            <div class="well pb-3 mt-3">
              <a href="/supplier" class="btn btn-secondary" tabindex="5">Atras</a>
              <button type="submit" class="btn btn-primary" tabindex="6">Aceptar</button>
            </div> 
   
        </form>
      </div>
    </div>
</div>
@stop

@section('js')
    <script src="https://kit.fontawesome.com/d2c478c6c0.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
      $(document).ready(function() {
        
         $("#div-off").hide();
         
         $("select[name='tipid']").change(function() {
            if ($(this).val() == "J") {
               
               $("#div-off").show();
            } else {
              
               $("#div-off").hide();
            }
         });
      });
   </script>
@stop
