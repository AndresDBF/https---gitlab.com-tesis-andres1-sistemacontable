@extends('adminlte::page')

@section('title', 'Retencion')

@section('content_header')
    <h1 class="mb-3">Comprobante de Retención de Impuesto al Valor Agregado</h1>
@stop

@section('content')
<div class="container">
    @if (session('error'))
        <div class="alert alert-danger">
            {{session('error')}}
        </div>
    @endif
    <form action="{{route('storeislr')}}" method="POST" id="myform">
        @csrf
        <div class="card">
            <div class="card-header">
                <h2 class="text-center">Datos de la Retención</h2>
            </div>
            <div class="card-body">
                <div class="well">
                    <div class="row">
                        <div class="col-xs-4 col-sm-4 col-md-4 mb-3">
                            <label for="" class="well-lg form-label">Número de Comprobante de Retención</label>
                            <input type="text" name="nvoucher" id="nvoucher" value="{{$nVoucher}}" class="form-control">
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <label for="" class="well-lg form-label">Fecha de Emisión</label>
                            <input type="text" name="fecemi" id="fecemi" value="{{$fecEmi}}"  class="form-control">
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <label for="" class="well-lg form-label">Periodo Fiscal</label>
                            <input type="text" name="perfiscal" id="perfiscal" value="{{$perFiscal}}" class="form-control">
                        </div>
                        <div class="col-xs-2 col-sm-2 col-md-2">
                            <label for="" class="well-lg form-label">Mes</label>
                            <input type="text" name="mouth" id="mouth" value="{{$month}}" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="" class="well-lg form-label">Nombre o Razon Social del Sujeto Retenido</label>
                    <input type="text" name="name" id="name" value="{{$supplier->nombre}}" class="form-control">
                </div>       
                <div class="well">
                    <div class="row">
                        <div class="col-xs-3 col-sm-6 col-md-4">
                            <div class="form-label">
                                <label for="dni">Tipo de Identificación</label>
                                <input type="text" name="tipid" class="form-control text-decoration-none" value="{{$supplier->tipid}}" readonly="readonly">
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-6 col-md-4">
                            <label for="" class="form-label">Rif o Cedula del Proveedor</label>
                            <input type="number" name="identification" id="identification" value="{{$supplier->identificacion}}" class="form-control text-decoration-none" readonly="readonly">
                        </div>
                        @if ($supplier->tipid != null)
                          <div class="col-xs-3 col-sm-6 col-md-4" id="div-off">
                            <label for="" class="form-label">Digito Verificador</label>
                            <input type="text" name="tiprif" class="form-control text-decoration-none" value="{{$supplier->tiprif}}" readonly="readonly">
                          </div>
                        @endif
                    </div>
                </div>
                <input type="hidden" name="numoper" value="{{$numOper}}">
                <input type="hidden" name="idorpa" value="{{$registerOrderPay->idorpa}}">
                <input type="hidden" name="idprov" value="{{$registerOrderPay->idprov}}">
                <input type="hidden" name="idage" value="{{$tipagent->idage}}">
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h2 class="text-center">Detalles de la Retención</h2>
            </div>
            <div class="card-body">
                <input type="hidden" name="fecemifact" value="{{$registerOrderPay->fec_emi}}">
                <div class="mb-3">
                    <label for="">Número de Operación</label>
                    <input type="text" name="numoper" class="form-control text-decoration-none" value="{{$numOper}}" readonly="readonly">
                </div>
                <div class="well mb-3">
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <label for="">Número de Factura</label>
                            <input type="text" name="numfact" class="form-control text-decoration-none">
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <label for="">Número de Control de Factura</label>
                            <input type="text" name="numctrl" class="form-control text-decoration-none">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="">Concepto de Retención</label>
                    <input type="text" name="concept" class="form-control text-decoration-none">
                </div>
                <div class="well">
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <label for="">Base Imponible</label>
                            <input type="text" name="base" id="base" class="form-control text-decoration-none" step="0.01" pattern="^\d+(\.\d{1,2})?$">
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <label for="">Porcentaje de Retencion</label>
                            @if ($tipagent->porcentajereten == 'N/A')
                                <input type="text" name="reten" id="reten" value="1" class="form-control text-decoration-none" step="0.01" pattern="^\d+(\.\d{1,2})?$">
                            @else
                            <input type="text" name="reten" id="reten" value="{{($tipagent->porcentajereten * 100)}}" class="form-control text-decoration-none" step="0.01" pattern="^\d+(\.\d{1,2})?$">
                            @endif
                            
                        </div>
                    </div>
                </div>
                <div class="well">
                    <div class="row">
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <label for="">Sustraendo</label>
                            @if ($tipagent->sustraendo == 'N/A')
                                <input type="text" name="sustra" id="sustra" value="7.50" class="form-control text-decoration-none" readonly="readonly" step="0.01" pattern="^\d+(\.\d{1,2})?$">
                            @else
                                <input type="text" name="sustra" id="sustra" value="{{$tipagent->sustraendo}}" class="form-control text-decoration-none" readonly="readonly" step="0.01" pattern="^\d+(\.\d{1,2})?$">
                            @endif
                           
                        </div>
                        <div class="col-xs-5 col-sm-5 col-md-5">
                            <label for="">Impuesto Retenido</label>
                            <input type="text" name="taxesreten" id="taxesreten" class="form-control text-decoration-none" readonly="readonly" step="0.01" pattern="^\d+(\.\d{1,2})?$">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{route('listpay')}}">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </a>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#seatmodal">Confirmar</button>
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
                                <h3 class="text-center">Cuenta Crédito</h3>
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
                                <h3 class="text-center">Cuenta Debito</h3>
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
                  <button type="button" class="btn btn-primary" onclick="confirmAsi('{{ route('storeretention') }}')">Guardar</button>
                </div>
              </div>
            </div>
        </div>
    </form>
</div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
  var myModal = document.getElementById('myModal')
  var myInput = document.getElementById('myInput')

  myModal.addEventListener('shown.bs.modal', function () {
    myInput.focus()
  })
</script>
<script src="{{asset('js/retentionislr.js')}}"></script>
<script src="{{asset('js/accountcredit.js')}}"></script>
<script src="{{asset('js/accountdebit.js')}}"></script>
<script>
    function confirmAsi(url) {
        Swal.fire({
            title: 'Confirmación',
            text: '¿Crear el comprobante de Retención de Impuesto Sobre la Renta?',
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
@endsection