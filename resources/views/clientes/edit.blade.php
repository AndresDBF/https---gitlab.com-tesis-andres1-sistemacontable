@extends('adminlte::page')

@section('title', 'Editar Cliente')

@section('content_header')
<h1 class="text-secondary fs-5 shadow-lg p-2 mb-5 bg-body rounded text-center">Editar Cliente</h1>
@stop

@section('content')
<div class="container"> 
  <div class="card">
    <div class="card-body">
      <form action="/clientes/{{$datecustom->idcli}}" method="POST">
        @csrf
          <div class="mb-3">
            <label for="" class="form-label">Codigo Cliente</label>
            <input type="text" name="code" id="code" class="form-control" readonly="readonly" value="{{$datecustom->idcli}}" tabindex="1">
          </div>
          <div class="well">
            <div class="row">
              <div class="col-xs-3 col-sm-6 col-md-6">
                <label for="" class="form-label">Nombre del Cliente</label>
                <input type="text" name="name" id="name" value="{{$datecustom->nombre}}" class="form-control" tabindex="2">
              </div>
              <div class="col-xs-3 col-sm-6 col-md-4">
                <label for="" class="form-label">Rif o Cedula del Cliente</label>
                <input type="number" name="identification" value="{{$datecustom->rif_cedula}}" id="identification" class="form-control text-decoration-none" tabindex="3">
              </div>
            </div>
          </div>
          
          <div class="mb-3">
            <label for="" class="form-label">Telefono</label>
            <input type="text" name="phone" id="phone" value="{{$datecustom->telefono}}" class="form-control" tabindex="4">
          </div>
          <div class="mb-3">
            <label for="" class="form-label">Correo Electronico</label>
            <input type="text" name="email" id="email" value="{{$datecustom->email}}" class="form-control" tabindex="5">
          </div>
          <div class="mb-3">
            <label for="" class="well-lg form-label">Dirección</label>
            <input type="text" name="direction" id="direction" value="{{$datecustom->direccion}}" class="form-control" tabindex="6">
          </div>
          <br>
    
          <h1 class="pb-6">Contrato del Cliente</h1>
          <div class="well">
            <div class="row">
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label for="dni">Estatus de Contrato</label>
                  <select name = 'stscontr' class="custom-select">
                    @if ($datecustom->stscontr == null)
                        <option selected="">Selecciona Estatus</option>
                    @else
                        <option value="{{$datecustom->stscontr}}">{{$datecustom->stscontr}}</option>
                    @endif
                    @foreach ($status as $sts)
                        <option value="{{$sts->id}}">{{$sts->sts}}</option> 
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-4">
                <div class="form-group">
                  <label for="dni">Tipo Pago</label>
                  <select name='tip_pag' class="custom-select">
                    @if ($datecustom->tip_pag == null)
                      <option selected="">Selecciona Estatus</option>
                    @endif
                      <option value="{{$datecustom->tip_pag}}">{{$datecustom->tip_pag}}</option>
                    @foreach ($methodpag as $method)
                      <option value="{{$method->tippago}}">{{$method->descripcion}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              
            </div>
            <div class="well">
              <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                  <label for="" class="form-label">Monto del Contrato</label>
                  <input type="number" name="valuecont" id="valuecont" value="{{$datecustom->monto_pag}}"class="form-control" tabindex="7">
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                  <div class="form-group">
                    <label for="dni">Moneda</label>
                    <select name = 'money' class="custom-select">
                        @if ($datecustom->moneda == null)
                            <option selected="">Selecciona Moneda</option>
                            @if($datecustom->moneda == "BOL ")
                                <option value="{{$datecustom->moneda}}">Bolivares</option>
                            @endif
                            @if($datecustom->moneda == "COP")
                                <option value="{{$datecustom->moneda}}">Pesos Colombianos</option>
                            @endif
                            @if($datecustom->moneda == "USD")
                                <option value="{{$datecustom->moneda}}">Dolar Estadounidense</option>
                            @endif
                        @endif
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
                    @if ($accounts == null)
                        <option selected="">Selecciona una cuenta</option>
                    @else
                        <option selected="">{{$accounts->tipcta}}</option>
                    @endif
                    @foreach ($accountlist as $account)
                        <option value="{{$account->idcta}}">{{$account->tipcta}}</option>
                    @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="dni">Tipo de Movimiento</label>
                <select name = 'account' class="custom-select">    
                    @if ($accounts == null)
                        <option selected="">Selecciona una Movimiento</option>
                    @else
                        <option value="{{$accounts->idcta}}">{{$accounts->tipmov}}</option>
                    @endif
                    @foreach ($accountlist as $account)
                        <option value="{{$account->idcta}}">{{$account->tipmov}}</option>
                    @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="dni">Nombre de Cuenta</label>
                <select name = 'account' class="custom-select">    
                    @if ($accounts == null)
                        <option selected="">Selecciona Nombre de Cuenta</option>
                    @else
                        <option selected="">{{$accounts->nombre_cuenta}}</option>
                    @endif
                    @foreach ($accountlist as $account)
                        <option value="{{$account->idcta}}">{{$account->nombre_cuenta}}</option>
                    @endforeach
                </select>
              </div>   
          </div>
    </div>
  </div>
  <div class="well pb-3">
    <a href="/clientes" class="btn btn-secondary" tabindex="5">Cancelar</a>
    <button type="submit" class="btn btn-primary" tabindex="6">Guardar</button>
  </div>  
      </form> 
</div>
<form action="/clientes/{{$datecustom->idcli}}" method="POST">
    @csrf
      <div class="mb-3">
        <label for="" class="form-label">Codigo Cliente</label>
        <input type="text" name="code" id="code" class="form-control" readonly="readonly" value="{{$datecustom->idcli}}" tabindex="1">
      </div>
      <div class="well">
        <div class="row">
          <div class="col-xs-3 col-sm-6 col-md-6">
            <label for="" class="form-label">Nombre del Cliente</label>
            <input type="text" name="name" id="name" value="{{$datecustom->nombre}}" class="form-control" tabindex="2">
          </div>
          <div class="col-xs-3 col-sm-6 col-md-4">
            <label for="" class="form-label">Rif o Cedula del Cliente</label>
            <input type="number" name="identification" value="{{$datecustom->rif_cedula}}" id="identification" class="form-control text-decoration-none" tabindex="3">
          </div>
        </div>
      </div>
      
      <div class="mb-3">
        <label for="" class="form-label">Telefono</label>
        <input type="text" name="phone" id="phone" value="{{$datecustom->telefono}}" class="form-control" tabindex="4">
      </div>
      <div class="mb-3">
        <label for="" class="form-label">Correo Electronico</label>
        <input type="text" name="email" id="email" value="{{$datecustom->email}}" class="form-control" tabindex="5">
      </div>
      <div class="mb-3">
        <label for="" class="well-lg form-label">Dirección</label>
        <input type="text" name="direction" id="direction" value="{{$datecustom->direccion}}" class="form-control" tabindex="6">
      </div>
      <br>

      <h1 class="pb-6">Contrato del Cliente</h1>
      <div class="well">
        <div class="row">
          <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
              <label for="dni">Estatus de Contrato</label>
              <select name = 'stscontr' class="custom-select">
                @if ($datecustom->stscontr == null)
                    <option selected="">Selecciona Estatus</option>
                @else
                    <option value="{{$datecustom->stscontr}}">{{$datecustom->stscontr}}</option>
                @endif
                @foreach ($status as $sts)
                    <option value="{{$sts->id}}">{{$sts->sts}}</option> 
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6 col-md-4">
            <div class="form-group">
              <label for="dni">Tipo Pago</label>
              <select name='tip_pag' class="custom-select">
                @if ($datecustom->tip_pag == null)
                  <option selected="">Selecciona Estatus</option>
                @endif
                  <option value="{{$datecustom->tip_pag}}">{{$datecustom->tip_pag}}</option>
                @foreach ($methodpag as $method)
                  <option value="{{$method->tippago}}">{{$method->descripcion}}</option>
                @endforeach
              </select>
            </div>
          </div>
          
        </div>
        <div class="well">
          <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
              <label for="" class="form-label">Monto del Contrato</label>
              <input type="number" name="valuecont" id="valuecont" value="{{$datecustom->monto_pag}}"class="form-control" tabindex="7">
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
              <div class="form-group">
                <label for="dni">Moneda</label>
                <select name = 'money' class="custom-select">
                    @if ($datecustom->moneda == null)
                        <option selected="">Selecciona Moneda</option>
                        @if($datecustom->moneda == "BOL ")
                            <option value="{{$datecustom->moneda}}">Bolivares</option>
                        @endif
                        @if($datecustom->moneda == "COP")
                            <option value="{{$datecustom->moneda}}">Pesos Colombianos</option>
                        @endif
                        @if($datecustom->moneda == "USD")
                            <option value="{{$datecustom->moneda}}">Dolar Estadounidense</option>
                        @endif
                    @endif
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
                @if ($accounts == null)
                    <option selected="">Selecciona una cuenta</option>
                @else
                    <option selected="">{{$accounts->tipcta}}</option>
                @endif
                @foreach ($accountlist as $account)
                    <option value="{{$account->idcta}}">{{$account->tipcta}}</option>
                @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="dni">Tipo de Movimiento</label>
            <select name = 'account' class="custom-select">    
                @if ($accounts == null)
                    <option selected="">Selecciona una Movimiento</option>
                @else
                    <option value="{{$accounts->idcta}}">{{$accounts->tipmov}}</option>
                @endif
                @foreach ($accountlist as $account)
                    <option value="{{$account->idcta}}">{{$account->tipmov}}</option>
                @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="dni">Nombre de Cuenta</label>
            <select name = 'account' class="custom-select">    
                @if ($accounts == null)
                    <option selected="">Selecciona Nombre de Cuenta</option>
                @else
                    <option selected="">{{$accounts->nombre_cuenta}}</option>
                @endif
                @foreach ($accountlist as $account)
                    <option value="{{$account->idcta}}">{{$account->nombre_cuenta}}</option>
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