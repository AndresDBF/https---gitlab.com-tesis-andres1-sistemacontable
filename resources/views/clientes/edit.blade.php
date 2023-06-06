@extends('adminlte::page')

@section('title', 'Editar Cliente')

@section('content_header')
<h1 class="text-secondary fs-5 shadow-lg p-2 mb-5 bg-body rounded text-center">Editar Cliente</h1>
@stop

@section('content')
<div class="container"> 
  <form action="/clientes/{{$customer->idcli}}" method="POST" id="myform">
    @csrf
    @method('PUT')
    <div class="card">
      <div class="card-header">
        <h3 class="text-center fw-bolder">Datos del Cliente</h3>
      </div>
      <div class="card-body pl-6">
        <div class="mb-3">
          <label for="" class="form-label">Codigo Cliente</label>
          <input type="text" name="code" id="code" class="form-control" readonly="readonly" value="{{$customer->idcli}}" tabindex="1">
        </div>
        
        <div class="mb-3">
          <label for="" class="form-label">Nombre del Cliente o Razón Social</label>
          @if($errors->first('name'))
            <p class="text-danger">{{$errors->first('name')}}</p>
          @endif
          <input type="text" name="name" id="name" value="{{$customer->nombre}}" class="form-control" tabindex="2">
        </div>
        <div class="well">
          <div class="row">
            <div class="col-xs-3 col-sm-6 col-md-4">
              <div class="form-label">
                  <label for="dni">Tipo de Identificación</label>
                  <select name = 'tipid' class="custom-select">
                    @if ($customer->tipid == 'V')
                      <option value="V">V</option>
                      <option value="J">J</option>
                      <option value="E">J</option>
                    @elseif ($customer->tipid == 'J')
                      <option value="J">J</option>
                      <option value="V">V</option>
                      <option value="E">E</option>
                    @elseif ($customer->tipid == 'E')
                      <option value="E">E</option>  
                      <option value="V">V</option>
                      <option value="J">J</option>
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
                <label for="" class="form-label">Rif o Cedula del Cliente</label>
                <input type="number" name="identification" id="identification" value="{{$customer->identificacion}}" class="form-control text-decoration-none" tabindex="6">
                @if($errors->first('identification'))
                  <p class="text-danger">{{$errors->first('identification')}}</p>
                @endif
            </div>
            <div class="col-xs-3 col-sm-6 col-md-4" id="div-off">
              <label for="" class="form-label">Digito Verificador</label>
              <select name = 'tiprif' class="custom-select" >
                @if($customer->tiprif != null)
                  <option value="{{$customer->tiprif}}">{{$customer->tiprif}}</option>
                  @for ($i = 0; $i < 9; $i++)
                  @if ($customer->tiprif == $i)
                    @continue
                  @endif
                  <option value="{{$i}}">{{$i}}</option>
                  @endfor
                @else
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
                @endif
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
              <input type="text" name="phone" id="phone" value="{{$customer->telefono}}" class="form-control" tabindex="4">
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
              <label for="" class="form-label">Correo Electronico</label>
              @if($errors->first('email'))
                <p class="text-danger">{{$errors->first('email')}}</p>
              @endif
              <input type="text" name="email" id="email" value="{{$customer->email}}" class="form-control" tabindex="5">
            </div>
          </div>
        </div>
        <div class="mb-3">
          <label for="" class="well-lg form-label">Dirección</label>
          @if($errors->first('direction'))
            <p class="text-danger">{{$errors->first('direction')}}</p>
          @endif
          <input type="text" name="direction" id="direction" value="{{$customer->direccion}}" class="form-control" tabindex="6">
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
                <select name="stscontr" class="custom-select" id="stscontr-select">
                  <option value="{{$contrCli->stscontr}}">{{$contrCli->stscontr}}</option>
                  @foreach ($status as $sts)
                    @if ($sts->sts == $contrCli->stscontr)
                        @continue
                    @endif
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
                <select name = 'tip_pag' class="custom-select">
                  @if ($contrCli->tip_pag == 'ANU')
                  <option value="{{$contrCli->tip_pag}}">ANUAL</option>
                  @elseif ($contrCli->tip_pag == 'MEN')
                  <option value="{{$contrCli->tip_pag}}">MENSUAL</option>
                  @elseif ($contrCli->tip_pag == 'SEM')
                  <option value="{{$contrCli->tip_pag}}">SEMESTRAL</option>
                  @else
                  <option value="{{$contrCli->tip_pag}}">TRIMESTRAL</option>
                  @endif
                    @foreach ($tippag as $tip)
                      @if ($tip->tippago == $contrCli->tip_pag)
                        @continue
                      @endif
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
                @if ($contrCli->moneda != 'BS')
                  <input type="number" name="valuecont"  id="valuecont" value="{{$contrCli->montopagmoneda}}" class="form-control" tabindex="7" readonly="readonly">
                @else
                  <input type="number" name="valuecont"  id="valuecont" value="{{$contrCli->montopaglocal}}" class="form-control" tabindex="7" readonly="readonly">
                @endif
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label for="dni">Moneda</label>
                  <select name = 'money' class="custom-select" id="money-select">
                    @if ($contrCli->moneda == 'BS')
                      <option value="{{$contrCli->moneda}}">BOLIVARES</option>
                    @elseif ($contrCli->moneda == 'USD')
                      <option value="{{$contrCli->tip_pag}}">DOLAR ESTADOUNIDENSE</option>
                    @elseif ($contrCli->moneda == 'EUR')
                      <option value="{{$contrCli->moneda}}">EUROS</option>
                    @else
                      <option value="{{$contrCli->moneda}}">PESOS COLOMBIANOS</option>
                    @endif
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
      <button type="button" class="btn btn-primary" onclick="confirmUpdate(event)">Confirmar</button>
    </div>

  </form>
</div> 
@stop

@section('js')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    $(document).ready(function() {
      
      

      
      $("select[name='tipid']").change(function() {
          if ($(this).val() == "J") {
            
            $("#div-off").show();
          } else {
            
            $("#div-off").hide();
          }
      });
    });
  </script>
  <script>
    function confirmUpdate(event) {
        event.preventDefault(); // Evita el envío del formulario por defecto

        Swal.fire({
            title: 'Confirmación',
            text: '¿Actualizar los datos del cliente?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                // Si se confirma, envía el formulario
                document.getElementById('myform').submit();
            }
        });
    }
  </script>

    
@endsection