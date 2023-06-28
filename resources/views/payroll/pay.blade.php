@extends('adminlte::page')

@section('title', 'Pago de Nomina')

@section('content_header')
    <h1 class="text-secondary fs-5 shadow-lg p-2 mb-5 bg-body rounded text-center">Pago de Nomina</h1>
@stop

@section('content')
@if (session('error'))
    <div class="alert alert-danger">
        {{session('error')}}
    </div>
@endif
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h2>Registrar Pago</h2>
                </div>
                <div class="card-body">
                    <form action="{{route('storepayemployee')}}" method="POST">
                        @csrf
                        <input type="hidden" name="idnom" value="{{$idnom}}">
                        <div class="mb-3">
                            <input type="hidden" name="valueVh" value="{{$valueVh->monto_valor}}">
                            <label for="" class="well-lg form-label">Dias Trabajados</label>
                            <input type="number" name="dayst" class="form-control">
                        </div>
                        <div class="well">
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <label for="" class="well-lg form-label">Horas Extras Diurnas</label>
                                    <select name="indhed" class="custom-select ind-selector" data-input-target="amounthed">
                                        <option value="N">No</option>
                                        <option value="S">Si</option>
                                    </select>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <input type="hidden" name="concepthed" value="{{$valueHed->concepto_valor}}" >
                                    <label for="" class="well-lg form-label">Ingrese el total de horas (Si Requiere)</label>
                                    <input type="number" name="amounthed" class="form-control input-amounthed">
                                </div>
                            </div>
                        </div>
                        
                        <div class="well">
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <label for="" class="well-lg form-label">Dias Feriados Trabajados</label>
                                    <select name="indfer" class="custom-select ind-selector" data-input-target="amountfes">
                                        <option value="N">No</option>
                                        <option value="S">Si</option>
                                    </select>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <label for="" class="well-lg form-label">Ingrese los dias (Si Requiere)</label>
                                    <input type="hidden" name="conceptfer" value="{{$valueFes->concepto_valor}}" >
                                    <input type="number" name="amountfer" id="amountfer" class="form-control">
                                </div>
                            </div>
                        </div>
                        
                        <div class="well">
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <label for="" class="well-lg form-label">Horas Extras Nocturnas</label>
                                    <select name="indhec" class="custom-select ind-selector" data-input-target="amounthec">
                                        <option value="N">No</option>
                                        <option value="S">Si</option>
                                    </select>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <label for="" class="well-lg form-label">Ingrese el total de horas (Si Requiere)</label>
                                    <input type="hidden" name="concepthen" value="{{$valueHen->concepto_valor}}" >
                                    <input type="number" name="amounthen" id="amounthen" class="form-control">
                                </div>
                            </div>
                        </div>
                        

                        <input type="hidden" name="conceptces" value="{{$valueCes->concepto_valor}}" >
                        <input type="hidden" name="cestaticket" value="{{$valueCes->monto_valor}}">
                        <div class="well">
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <label for="" class="well-lg form-label">Monto del Incentivo de mes</label>
                                    <input type="number" name="incent" class="form-control">
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4">
                                    <div class="form-group">
                                      <label for="dni">Moneda</label>
                                      <select name = 'money' id="money-select" class="custom-select">
                                        <option value="select">Selecciona un tipo de pago</option>
                                          @foreach ($money as $mon)
                                              <option value="{{$mon->tipmoneda}}">{{$mon->descripcion}}</option>
                                          @endforeach
                                      </select>
                                      <input type="hidden" name="tasa_cambio" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                       

                        <div class="well mt-3">
                            <a href="/payroll" class="btn btn-secondary" tabindex="5">Atras</a>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#seatmodal">Aceptar</button>  
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
                                      <input type="text" class="form-control" name="observation" id="observation">
                                    </div>
                                    <div class="mb-3">
                                      <label for="message-text" class="col-form-label">Descripcion</label>
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
                </div>
            </div>
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
    <script 
    src="http://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
    crossorigin="anonymous">
    </script>
    <script src="{{asset('js/process/seat.js')}}"></script>
    <script>
        document.getElementById('money-select').addEventListener('change', function() {
            var selectedOption = this.value;
            if (selectedOption !== 'BS') {
                var tasaCambio = prompt('Ingrese la tasa de cambio:');
                document.querySelector('input[name="tasa_cambio"]').value = tasaCambio;
            }
        });
    </script>
    
@endsection