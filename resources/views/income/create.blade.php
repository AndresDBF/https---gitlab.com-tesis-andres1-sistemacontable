@extends('adminlte::page')

@section('title', 'Ingreso')

@section('content_header')
    <h1>Creación de Ingreso</h1>
@stop

@section('content')
<div class="container">
    @if(session('error'))
    <div class="alert alert-success" role="alert">
        {{ session('error') }}
    </div>
    @endif
    <div class="card">
        <div class="card-body pl-6">
        <h3 class="text-center fw-bolder pb-4">Ingresa la Identificación del Beneficiario de la Factura</h3>
            <div class="well">
                <div class="row">
                    <div class="col-xs-3 col-sm-6 col-md-4">
                        <div class="form-label">
                            <label for="dni">Tipo de Identificación</label>
                            <select name = 'tipid' class="custom-select">
                                @if ($customer->tipid == 'V')
                                    <option value="V">V</option>
                                    <option value="J">J</option>
                                    <option value="E">E</option>
                                @elseif($customer->tipid == 'J')
                                    <option value="J">J</option>
                                    <option value="V">V</option>
                                    <option value="E">E</option>
                                @elseif($customer->tipid == 'E')
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
                        <input type="number" name="identification" value="{{$customer->identificacion}}" id="identification" class="form-control text-decoration-none">
                    </div>
                    <div class="col-xs-3 col-sm-6 col-md-4">
                        <label for="" class="form-label">Numero de Chequeo</label>
                        <select name = 'numcheck' class="custom-select">
                            @if ($customer->tiprif == null)
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
                                    @if ($i == $customer->tiprif)
                                        <option value="{{$i}}" selected readonly = "readonly">{{$i}}</option>
                                    @endif
                                    <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            
                            @endif
                            
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body pl-6">
        <h3 class="text-center fw-bolder">Creacion de  Ingreso</h3>
        <form action="{{route('storeIncome')}}" method="POST" id="myform">
            @csrf
            <div class="well">
                <div class="row">
                    <div class="col-xs-3 col-sm-3 col-md-3">
                        <label for="" class="form-label">Fecha de Transacción</label>
                        <input type="text" name="fecTransiction" value="{{$proofIncome->fec_trans}}" id="fecTransiction" readonly="readonly" class="form-control text-decoration-none text-center">
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3">
                        <label for="" class="form-label">Fecha de Ingreso</label>
                        <input type="text" name="fecIncome" value="{{$fecRegister}}" id="fecTransiction" readonly="readonly" class="form-control text-decoration-none text-center">
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3">
                        <label for="" class="form-label">Numero de Confirmación</label>
                        <input type="text" name="numconfirm" value="{{$proofIncome->numconfirm}}" id="numconfirm" class="form-control text-decoration-none" tabindex="1">
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3">
                        <label for="" class="form-label">Numero de factura</label>
                        <input type="text" name="numfact" value="{{$proofIncome->numfact}}" id="numfact" readonly="readonly" class="form-control text-decoration-none">
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Nombre y Apellido o Razon Social</label>
                <input type="text" name="name" id="name" value="{{$customer->nombre}}" class="form-control" readonly="readonly">
            </div>
            <div class="well">
                <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <label for="" class="">Forma de Pago</label>
                        <select name="formPay" class="custom-select">
                            @if ($proofIncome->formpago == "EFE")
                                <option value="{{$proofIncome->formpago}}" readonly="readonly" >EFECTIVO</option>
                            @elseif ($proofIncome->formpago == "TRA")
                                <option value="{{$proofIncome->formpago}}" readonly="readonly" >TRANSFERENCIA BANCARIA</option>
                            @elseif ($proofIncome->formpago == "PMO")
                                <option value="{{$proofIncome->formpago}}" readonly="readonly" >PAGO MOVIL</option>
                            @elseif ($proofIncome->formpago == "TDE")
                                <option value="{{$proofIncome->formpago}}" readonly="readonly" >TARJETA DE DEBITO</option>    
                            @elseif($proofIncome->formpago == "TRC")
                                <option value="{{$proofIncome->formpago}}">TARJETA DE CREDITO</option>    
                            @endif
                        </select>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <label for="" class="form-label">Moneda</label>
                        <select name = 'money' class="custom-select" @readonly(true)>
                            @if ($contrCli->moneda == 'BS')
                                <option value="{{$contrCli->moneda}}">BOLIVARES</option>
                            @elseif ($contrCli->moneda == 'USD')
                                <option value="{{$contrCli->moneda}}">DOLAR ESTADOUNIDENSE</option>
                            @elseif ($contrCli->moneda == 'COP')
                                <option value="{{$contrCli->moneda}}">PESOS COLOMBIANOS</option>
                            @elseif ($contrCli->moneda == "EUR")
                                <option value="{{$contrCli->moneda}}">EUROS</option>
                            @endif
                           
                               
                          
                        </select>
                    </div>

                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <label for="" class="form-label">Cantidad</label>
                        @if ($contrCli->moneda != 'BS')
                            <input type="text" name="amount" value="{{$proofIncome->mtomoneda}}" id="amount" class="form-control" tabindex="4" readonly="readonly">
                        @else
                        <input type="text" name="amount" value="{{$proofIncome->mtolocal}}" id="amount" class="form-control" tabindex="4" readonly="readonly">
                        @endif
                        <input type="hidden" name="finalamount" value="{{$proofIncome->mtomoneda}}" id="amount" class="form-control" tabindex="4" readonly="readonly">
                        
                    </div>
                </div>
            </div>
            <div class="mb-3 mt-3">
                <label for="" class="form-label">Por Concepto de</label>
                
                @if($errors->first('byconcept'))
                    <p class="text-danger">{{$errors->first('byconcept')}}</p>
                @endif
                <input type="text" name="byconcept" id="byconcept" class="form-control" tabindex="5">
            </div>
            <div class="mb-3 mt-3">
                <label for="" class="form-label">Descripción de Comprobante de Ingreso</label>
                @if($errors->first('descriptioni'))
                    <p class="text-danger">{{$errors->first('descriptioni')}}</p>
                @endif
                <textarea class="form-control" name="descriptioni" aria-valuemax="{{$proofIncome->descripcion}}" id="description" tabindex="6"></textarea>
            </div>
            <input type="hidden" name="iddcomp" id="iddcomp" value="{{$proofIncome->iddcomp}}">
            <input type="hidden" name="idcli" id="idcli" value="{{$customer->idcli}}">
            <input type="hidden" name="iddfact" id="iddfact" value="{{$detInvoice->iddfact}}">
            <input type="hidden" name="tasa" id="tasa" value="{{$proofIncome->tasa_cambio}}">
            <input type="hidden" name="montoasiento" id="montoasiento" value="{{$detInvoice->mtolocal}}">

            
           {{--  <div class="well pb-3 mt-3">
                <a href="{{route('searchIncome')}}">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Atras</button>
                </a>
                <button type="submit" class="btn btn-primary" id="submitForm">Aceptar</button>
            </div> --}}
            <div class="well pb-3">
                <a href="{{route('searchIncome')}}" class="btn btn-secondary" tabindex="5">Cancelar</a>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#seatmodal">Confirmar</button>
                {{-- <button type="submit" class="btn btn-primary" tabindex="6">Guardar</button>--}}
                <!-- Modal -->
            </div>
        
    </div>
</div>
<div class="modal fade" id="seatmodal" tabindex="-1" aria-labelledby="seatmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header text-center">
          <h5 class="modal-title" id="seatmodalLabel">Completar Asiento Contable Final</h5>
          {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <p>Cerrar</p>
          </button> --}}
        </div>
        <div class="modal-body">
            <div class="well">
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <h3 class="text-center">Cuenta Debito</h3>
                          <div class="form-group">
                          <label for="groupaccount">Grupo de Cuenta</label>
                          <select name = 'groupaccount1' id ="groupaccount1" class="custom-select">
                              <option selected="">Seleccionar Grupo</option>
                          </select>
                          </div>
                          <div class="form-group">
                          <label for="subgroupaccount">Subgrupo de Cuenta</label>
                          <select name = 'subgroupaccount1' id ="subgroupaccount1" class="custom-select">
                              <option selected="">Seleccionar Subgrupo</option>
                          </select>
                          </div> 
                          <div class="form-group">
                          <label for="accountname">Nombre de Cuenta</label>
                          <select name = 'accountname1'id="accountname1" class="custom-select">
                              <option selected="">Seleccionar Cuenta</option>
                          </select>
                          </div>
                          <div class="form-group">
                          <label for="subaccountname">Nombre de Subcuenta</label>
                          <select name = 'subaccountname1'id="subaccountname1" class="custom-select">
                              <option selected="">Seleccionar Subcuenta</option>
                          </select>
                          <input type="hidden" name="subaccount_tipsubcta1" id="subaccount_tipsubcta1" value="">
                          <input type="hidden" name="subaccount_descripcion1" id="subaccount_tipsubcta1" value="">
                          </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <h3 class="text-center">Cuenta Credito</h3>
                          <div class="form-group">
                          <label for="groupaccount">Grupo de Cuenta</label>
                          <select name = 'groupaccount2' id ="groupaccount2" class="custom-select">
                              <option selected="">Seleccionar Grupo</option>
                          </select>
                          </div>
                          <div class="form-group">
                          <label for="subgroupaccount">Subgrupo de Cuenta</label>
                          <select name = 'subgroupaccount2' id ="subgroupaccount2" class="custom-select">
                              <option selected="">Seleccionar Subgrupo</option>
                          </select>
                          </div> 
                          <div class="form-group">
                          <label for="accountname">Nombre de Cuenta</label>
                          <select name = 'accountname2'id="accountname2" class="custom-select">
                              <option selected="">Seleccionar Cuenta</option>
                          </select>
                          </div>
                          <div class="form-group">
                          <label for="subaccountname">Nombre de Subcuenta</label>
                          <select name = 'subaccountname2'id="subaccountname2" class="custom-select">
                              <option selected="">Seleccionar Subcuenta</option>
                          </select>
                          <input type="hidden" name="subaccount_tipsubcta2" id="subaccount_tipsubcta2" value="">
                          <input type="hidden" name="subaccount_descripcion2" id="subaccount_tipsubcta2" value="">
                          </div>
                    </div>
                </div>
            </div>
            <div class="mb-3">
              <label for="recipient-name" class="col-form-label">Observacion</label>
              @if($errors->first('observation'))
                <p class="text-danger">{{$errors->first('observation')}}</p>
              @endif
              <input type="text" class="form-control" name="observation" id="observation">
            </div>
            <div class="mb-3">
              <label for="message-text" class="col-form-label">Descripcion</label>
              @if($errors->first('description'))
                <p class="text-danger">{{$errors->first('description')}}</p>
              @endif
              <textarea class="form-control" name="description" id="description"></textarea>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </div>
    </div>
</div>
</form>
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
  {{-- scripts js --}}
  <script src="{{asset('js/process/seat.js')}}">
  
  </script>
  <script>// Obtener los elementos select y input
    var subaccount_tipsubcta1 = document.getElementById("subaccount_tipsubcta1");
    var subaccount_descripcion1 = document.getElementById("subaccount_descripcion1");

    var subaccount_tipsubcta2 = document.getElementById("subaccount_tipsubcta2");
    var subaccount_descripcion2 = document.getElementById("subaccount_descripcion2");

    var account1 = document.getElementById("account1");
    var account1 = document.getElementById("account1");

    var nameaccount2 = document.getElementById("nameaccount2");
    var nameaccount2 = document.getElementById("nameaccount2");
    
    
    // Agregar eventos "change" a los select
    subaccount_tipsubcta1.addEventListener("change", updateInputs);
    subaccount_descripcion1.addEventListener("change", updateInputs);
    subaccount_tipsubcta2.addEventListener("change", updateInputs);
    subaccount_descripcion2.addEventListener("change", updateInputs);
    
    function updateInputs() {
        // Obtener los valores seleccionados en los select
        var subaccount_tipsubcta1Value = subaccount_tipsubcta1.value;
        var subaccount_descripcion1Value = subaccount_descripcion1.value;
        var subaccount_tipsubcta2Value = subaccount_tipsubcta2.value;
        var subaccount_descripcion2Value = subaccount_descripcion2.value;
    
        // Asignar los valores a los inputs correspondientes
        account1.value = subaccount_tipsubcta1Value;
        nameaccount1.value = subaccount_descripcion1Value;
        account2.value = subaccount_tipsubcta2Value;
        nameaccount2.value = subaccount_descripcion2Value;
    }
    </script>

  <script 
      src="http://code.jquery.com/jquery-3.3.1.min.js"
      integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
      crossorigin="anonymous">
  </script>
@stop