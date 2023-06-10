@extends('adminlte::page')

@section('title', 'Orden de Pago')

@section('content_header')
    <h1>Orden de Pago </h1>
@stop

@section('content')
    <div class="container">
        @if(Session::has('error'))
            <div class="alert alert-danger">{{Session::get('error')}}</div>
        @endif 
        <div class="card">
            <div class="card-body pl-6">
                <form action="{{route('storeord')}}" method="POST">
                    @csrf
                    <input type="hidden" name="idprov" id="idprov" value="{{$idprov}}">
                    <input type="hidden" name="idorco" id="idorco" value="{{$idorco}}">
                    <div class="well">
                        <div class="row">
                            <div class="col-xs-3 col-sm-6 col-md-6">
                                <label for="" class="form-label">Numero de Relacion de Egreso</label>
                                <input type="text" name="numrelegre" id="code" class="form-control" readonly="readonly" value="{{$numegre}}">
                            </div>
                            <div class="col-xs-3 col-sm-6 col-md-6">
                                <label for="" class="form-label">fecha de emision</label>
                                <input type="text" name="fecemi" id="fecemi"  class="form-control" value="{{$fecEmi}}" readonly="readonly">
                            </div>
                        </div>
                    </div>
                    <div class="well">
                        <div class="row">
                            <div class="col-xs-3 col-sm-6 col-md-6">
                                <label for="" class="form-label">Numero de Factura</label>
                                @if($errors->first('numfact'))
                                    <p class="text-danger">{{$errors->first('numfact')}}</p>
                                @endif
                                <input type="numeric" name="numfact" id="numfact"  class="form-control" tabindex="1">
                            </div>
                            <div class="col-xs-3 col-sm-6 col-md-6">
                                <label for="" class="form-label">Control de Factura</label>
                                @if($errors->first('numfact'))
                                    <p class="text-danger">{{$errors->first('numfact')}}</p>
                                @endif
                                <input type="text" name="numctrl" id="numctrl"  class="form-control" tabindex="2">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Nombre y Apellido o Razon Social</label>
                        @if($errors->first('name'))
                            <p class="text-danger">{{$errors->first('name')}}</p>
                        @endif
                        <input type="text" name="name" id="name" value="{{$supplier->nombre}}" class="form-control" tabindex="3">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Direccion de Factura</label>
                        @if($errors->first('direction'))
                            <p class="text-danger">{{$errors->first('direction')}}</p>
                        @endif
                        <input type="text" name="direction" id="direction" value="{{$supplier->direccion}}" class="form-control" tabindex="4">
                    </div>
                    
                    <div class="well">
                        <div class="row">
                            <div class="col-xs-3 col-sm-6 col-md-4">
                                <div class="form-label">
                                    <label for="dni">Tipo de Identificación</label>
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
                                <label for="" class="form-label">Rif o Cedula del Cliente</label>
                                @if($errors->first('identification'))
                                    <p class="text-danger">{{$errors->first('identification')}}</p>
                                @endif
                                <input type="number" name="identification" id="identification" value="{{$supplier->identificacion}}" class="form-control text-decoration-none" tabindex="5">
                            </div>
                            <div class="col-xs-3 col-sm-6 col-md-4">
                                <label for="" class="form-label">Numero de Chequeo</label>
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
                                                <option value="{{$i}}" selected readonly = "readonly">{{$i}}</option>
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
                        <input type="number" name="phone" id="phone" value="{{$supplier->telefono}}" class="form-control text-decoration-none" tabindex="6">
                    </div>
                    <div class="well">
                        <div class="row">
                            <div class="col-xs-4 col-sm-4">
                                <div class="form-group">
                                  <label for="dni">Tipo de Pago</label>
                                  <select name = 'tip_pag' id="form-pay-select" class="custom-select">
                                    <option selected="">Selecciona un tipo de pago</option>
                                      @foreach ($tippag as $tip)
                                          <option value="{{$tip->tippago}}">{{$tip->descripcion}}</option>
                                      @endforeach
                                  </select>
                                  @if($errors->first('errorpag'))
                                    <p class="text-danger">{{$errors->first('errorpag')}}</p>
                                  @endif
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-4">
                                <div class="form-group">
                                  <label for="dni">Tipo de Moneda</label>
                                  <select name = 'money' id="money-select" class="custom-select">
                                    <option selected="">Selecciona el tipo de moneda</option>
                                      @foreach ($money as $tip)
                                          <option value="{{$tip->tipmoneda}}">{{$tip->descripcion}}</option>
                                      @endforeach
                                  </select>
                                  @if($errors->first('errormon'))
                                    <p class="text-danger">{{$errors->first('errormon')}}</p>
                                  @endif
                                </div>
                            </div>
                            <input type="hidden" name="tasa_cambio" value="">
                            <div class="col-xs-4 col-sm-4">
                                <label for="dni">Numero Total de descripcion de factura</label>
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
                        <a href="/home" class="btn btn-secondary" tabindex="7">Cancelar</a>
                        <button type="submit" class="btn btn-primary" tabindex="8">Siguiente</button>
                    </div> 
                </form> 
            </div>
        </div>   
    </div>
@stop

@section('js')
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
        document.getElementById('money-select').addEventListener('change', function() {
            var selectedOption = this.value;
            if (selectedOption != 'BS') {
                var tasaCambio = prompt('Ingrese la tasa de cambio:');
                document.querySelector('input[name="tasa_cambio"]').value = tasaCambio;
            }
        });
    </script>
@endsection
