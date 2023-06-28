@extends('adminlte::page')

@section('title', 'Facturación')

@section('content_header')
    <h1>Facturación </h1>
@stop

@section('content')
    <div class="container"> 
        <div class="card">
            <div class="card-body pl-6">
                <form action="{{route('storeinvoiceing')}}" method="POST">
                    @csrf
                    <input type="hidden" name="idcli" value="{{$idcli}}">
                    <div class="well">
                        <div class="row">
                            <div class="col-xs-3 col-sm-6 col-md-6">
                                <label for="" class="form-label">Numero de Relacion de ingreso</label>
                                <input type="text" name="numreling" id="code" class="form-control" readonly="readonly" value="{{$numing}}">
                            </div>
                            <div class="col-xs-3 col-sm-6 col-md-6">
                                <label for="" class="form-label">fecha de emision</label>
                                <input type="text" name="fecemi" id="fecemi"  class="form-control" tabindex="1" value="{{$fecemi}}" readonly="readonly">
                            </div>
                        </div>
                    </div>
                    <div class="well">
                        <div class="row">
                            <div class="col-xs-3 col-sm-6 col-md-6">
                                <label for="" class="form-label">Numero de Factura</label>
                                <input type="numeric" name="numfact" id="numfact" value="000{{$numfact}}" class="form-control" tabindex="2">
                            </div>
                            <div class="col-xs-3 col-sm-6 col-md-6">
                                <label for="" class="form-label">Control de Factura</label>
                                <input type="text" name="numctrl" id="numctrl" value="00-000{{$numctrl}}" class="form-control" tabindex="3">
                            </div>
                            
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Nombre y Apellido o Razon Social</label>
                        <input type="text" name="name" id="name" value="{{$customer->nombre}}" class="form-control" readonly="readonly">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Direccion de Factura</label>
                        @error('stscontr')
                            <div class="alert alert-danger">{{ "Estatus Invalido" }}</div>
                        @enderror
                        <input type="text" name="direction" id="direction" value="{{$customer->direccion}}" class="form-control" readonly="readonly">
                    </div>
                    <div class="well">
                        <div class="row">
                            <div class="col-xs-3 col-sm-6 col-md-4">
                                <div class="form-label">
                                    <label for="dni">Tipo de Identificación</label>
                                    <input type="text" name="tipid" id="direction" value="{{$customer->tipid}}" class="form-control" readonly="readonly">
                                </div>
                            </div>
                            <div class="col-xs-3 col-sm-6 col-md-4">
                                <label for="" class="form-label">Rif o Cedula del Cliente</label>
                                @error('stscontr')
                                    <div class="alert alert-danger">{{ "Estatus Invalido" }}</div>
                                @enderror
                                <input type="number" name="identification" id="identification" value="{{$customer->identificacion}}" class="form-control text-decoration-none" readonly="readonly">
                            </div>
                            @if ($customer->tiprif != null)
                                <div class="col-xs-3 col-sm-6 col-md-4">
                                    <label for="" class="form-label">Digito Verificador</label>
                                    <input type="number" name="tiprif" id="tiprif" value="{{$customer->tiprif}}" class="form-control text-decoration-none" readonly="readonly">
                                </div>
                            @endif
                            
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Telefono</label>
                        <input type="number" name="phone" id="phone" value="{{$customer->telefono}}" class="form-control text-decoration-none" readonly="readonly">
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
                                  @error('stscontr')
                                    <div class="alert alert-danger">{{ "Estatus Invalido" }}</div>
                                  @enderror
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-4">
                                <div class="form-group">
                                    <label for="dni">Moneda</label>
                                    <select name = 'money-select' id="money-select" class="custom-select">
                                      <option selected="">Selecciona una Moneda</option>
                                        @foreach ($money as $mon)
                                            <option value="{{$mon->tipmoneda}}">{{$mon->descripcion}}</option>
                                        @endforeach
                                    </select>
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
                        <a href="/home" class="btn btn-secondary" tabindex="4">Cancelar</a>
                        <button type="submit" class="btn btn-primary" tabindex="5">Siguiente</button>
                    </div> 
                </form> 
            </div>
        </div>   
    </div>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>      
        document.getElementById('money-select').addEventListener('change', function() {
            var formPayValue = document.getElementById('form-pay-select').value;
            var moneyValue = this.value;
      
            if (formPayValue === 'PMO' && moneyValue !== 'BS') {
                alert('No se puede realizar pago móvil en moneda extranjera.');
            }
        });
      </script>
     <script src="{{ asset('js/process/verifytippay.js') }}"></script>
    
@endsection