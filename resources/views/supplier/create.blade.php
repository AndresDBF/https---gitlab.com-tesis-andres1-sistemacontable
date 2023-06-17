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
                      <label for="" class="form-label">Rif o Cedula del Proveedor</label>
                      <input type="number" name="identification" id="identification" class="form-control text-decoration-none" tabindex="6">
                      @if($errors->first('identification'))
                        <p class="text-danger">{{$errors->first('identification')}}</p>
                      @endif
                  </div>
                  <div class="col-xs-3 col-sm-6 col-md-4" id="div-off">
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
                <label for="dni">Categoria</label>
                @if ($errors->first('category'))
                  <p class="text-danger">{{$errors->first('email')}}</p>
                @endif
                <select name = 'category' class="custom-select">
                  <option selected="">Selecciona la Categoria</option>
                    @foreach ($tipSupplier as $tip)
                      <option value="{{$tip->tip_prove}}">{{$tip->descripcion}}</option>
                    @endforeach
                </select>
            </div>
            <div class="well pb-3 mt-3">
              <a href="/supplier" class="btn btn-secondary" tabindex="5">Atras</a>
              <button type="button" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#seatmodal" tabindex="6">Aceptar</button>
            </div> 
            <div class="modal fade" id="seatmodal" tabindex="-1" aria-labelledby="seatmodalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header text-center">
                    <h5 class="modal-title" id="seatmodalLabel">¿El Proveedor es Contribuyente especial?</h5>
                  </div>
                  <div class="modal-body">
                    <div class="col-xs-3 col-sm-6 col-md-4 text-center">
                      <select name = 'reten' id="reten" class="custom-select">
                        <option value="N">NO</option>
                        <option value="S">SI</option>
                    </select>
                    <input type="hidden" name="porcreten" id="porcreten">
                    </div> {{-- CREAR LA OPCION DE CONTRIBUYENTE ESPECIAL PARA EL PROVEEDOR --}}
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                  </div>
                </div>
              </div>
          </div>
        </form>
      </div>
    </div>
</div>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
      var myModal = document.getElementById('myModal')
      var myInput = document.getElementById('myInput')

      myModal.addEventListener('shown.bs.modal', function () {
        myInput.focus()
      })
    </script>
    <script src="https://kit.fontawesome.com/d2c478c6c0.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{asset('js/verifyidentification.js')}}"></script>
   <script src="{{asset('js/contribuyente.js')}}"></script>
   
@stop
