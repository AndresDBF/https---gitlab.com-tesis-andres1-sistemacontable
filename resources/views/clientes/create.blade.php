@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')
    <h1 class="text-secondary fs-5 shadow-lg p-2 mb-5 bg-body rounded text-center">Nuevo Cliente</h1>
@stop

@section('content')
<div class="container"> 
  <div class="card">
    <div class="card-header">
      <h3 class="text-center fw-bolder">Datos del Cliente</h3>
    </div>
    <div class="card-body pl-6">
      <form action="/clientes" method="POST" id="myform">
        @csrf
        <div class="mb-3">
          <label for="" class="form-label">Codigo Cliente</label>
          <input type="text" name="code" id="code" class="form-control" readonly="readonly" value="{{$idsigue}}" tabindex="1">
        </div>
        
        <div class="mb-3">
          <label for="" class="form-label">Nombre del Cliente o Razón Social</label>
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
              <div class="col-xs-3 col-sm-6 col-md-4" id="div-off">
                  <label for="" class="form-label">Digito Verificador</label>
                  <select name = 'tiprif' class="custom-select" >
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
        <div class="well">
          <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
              <label for="" class="form-label">Telefono</label>
              @if($errors->first('phone'))
                <p class="text-danger">{{$errors->first('phone')}}</p>
              @endif
              <input type="text" name="phone" id="phone" class="form-control" tabindex="4">
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
              <label for="" class="form-label">Correo Electronico</label>
              @if($errors->first('email'))
                <p class="text-danger">{{$errors->first('email')}}</p>
              @endif
              <input type="text" name="email" id="email" class="form-control" tabindex="5">
            </div>
          </div>
        </div>
        <div class="mb-3">
          <label for="" class="well-lg form-label">Dirección</label>
          @if($errors->first('direction'))
            <p class="text-danger">{{$errors->first('direction')}}</p>
          @endif
          <input type="text" name="direction" id="direction" class="form-control" tabindex="6">
        </div>
    </div> 
  </div>
  <div class="card">
    <div class="card-header">
      <h3 class="text-center fw-bolder">Datos del Contrato</h3>
    </div>
    <div class="card-body pl-6">          
      <div class="well">
        <div class="row">
          <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
              <label for="dni">Estatus de Contrato</label>
              <select name="stscontr" class="custom-select" id="stscontr-select" onchange="checkStatus(this)">
                <option selected>Selecciona el Estatus de contrato</option>
                @foreach ($status as $sts)
                  <option value="{{$sts->sts}}">{{$sts->sts}}</option>
                @endforeach
              </select>
              @error('stscontr')
                <div class="alert alert-danger">{{ "Estatus Invalido" }}</div>
              @enderror
            </div>
          </div>
          <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
              <label for="dni">Tipo de Pago</label>
              <select name = 'tip_pag' id="form-pay-select" class="custom-select">
                <option selected="">Selecciona un tipo de pago</option>
                  @foreach ($tippag as $tip)
                      <option value="{{$tip->tippago}}">{{$tip->descripcion}}</option>
                  @endforeach
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
                <select name = 'money' class="custom-select" id="money-select">
                  <option selected="">Selecciona una Moneda</option>
                    @foreach ($money as $mon)
                      <option value="{{$mon->tipmoneda}}">{{$mon->descripcion}}</option>
                    @endforeach
                </select>
              </div>
            </div>
            <input type="hidden" name="tasa_cambio" value="">
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="well pb-3">
    <a href="/clientes" class="btn btn-secondary" tabindex="5">Cancelar</a>
    <button type="button" class="btn btn-primary" onclick="confirmAsi('{{ route('clientes.store') }}')">Guardar</button>
  </div>
</form> 
</div>
  
  
@stop
@section('js')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
  <script src="{{asset('js/verifytippay.js')}}">
    
</script>

<script>
  document.getElementById('money-select').addEventListener('change', function() {
      var formPayValue = document.getElementById('form-pay-select').value;
      var moneyValue = this.value;

      if (formPayValue === 'PMO' && moneyValue !== 'BS') {
          alert('No se puede realizar pago móvil en moneda extranjera.');
      }
  });
</script>

  <script>
    function checkStatus(selectElement) {
      var selectedValue = selectElement.value;
      if (selectedValue === 'ANU' || selectedValue === 'RET') {
        alert('El estatus seleccionado es incorrecto para este proceso.');
        selectElement.value = "";
      }
    }
  </script>
  <script>
    function confirmAsi(url) {
        Swal.fire({
            title: 'Confirmación',
            text: '¿Crear Cliente?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('myform').submit(); // Envía el formulario
            }
        });
    }
</script>
@stop