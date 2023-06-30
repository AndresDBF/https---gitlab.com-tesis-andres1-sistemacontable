@extends('adminlte::page')

@section('title', 'Retencion')

@section('content_header')
    <h1>Comprobante de Retención de Impuesto al Valor Agregado</h1>
@stop

@section('content')
<div class="container">
    @if (session('error'))
        <div class="alert alert-danger">
            {{session('error')}}
        </div>
    @endif
    <form action="{{route('storeretening')}}" method="POST" id="myform">
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
                    <input type="text" name="name" id="name" value="{{$customer->nombre}}" class="form-control">
                </div>       
                <div class="well">
                    <div class="row">
                        <div class="col-xs-3 col-sm-6 col-md-4">
                            <div class="form-label">
                                <label for="dni">Tipo de Identificación</label>
                                <input type="text" name="tipid" class="form-control text-decoration-none" value="{{$customer->tipid}}" readonly="readonly">
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-6 col-md-4">
                            <label for="" class="form-label">Rif o Cedula del Proveedor</label>
                            <input type="number" name="identification" id="identification" value="{{$customer->identificacion}}" class="form-control text-decoration-none" readonly="readonly">
                        </div>
                        @if ($customer->tiprif != null)
                          <div class="col-xs-3 col-sm-6 col-md-4" id="div-off">
                            <label for="" class="form-label">Digito Verificador</label>
                            <input type="text" name="tiprif" class="form-control text-decoration-none" value="{{$customer->tiprif}}" readonly="readonly">
                          </div>
                        @endif
                    </div>
                </div>
                <input type="hidden" value="{{$numOper}}" name="numoper">
                <input type="hidden" name="idfact" value="{{$registerIncome->idfact}}">
                <input type="hidden" value="{{$registerIncome->idcli}}" name="idcli">
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h2 class="text-center">Detalles de la Retención</h2>
            </div>
            <div class="card-body">
                <input type="hidden" name="fecemifact" value="{{$registerIncome->fec_emi}}">
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
                <div class="well">
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <label for="">Base Imponible</label>
                            <input type="text" name="base" id="base" class="form-control text-decoration-none" step="0.01" pattern="^\d+(\.\d{1,2})?$">
                        </div>
                        <div class="col-xs-2 col-sm-2 col-md-2">
                            <label for="">Porcentaje de I.V.A</label>
                            <input type="text" name="iva" id="iva" class="form-control text-decoration-none" step="0.01" pattern="^\d+(\.\d{1,2})?$">
                        </div>
                    </div>
                </div>
                <div class="well">
                    <div class="row">
                        <div class="col-xs-3 col-sm-6 col-md-4">
                            <label for="">Total Compras Incluyendo Impuesto</label>
                            <input type="text" name="totaltaxes" id="totaltaxes" class="form-control text-decoration-none" readonly="readonly" step="0.01" pattern="^\d+(\.\d{1,2})?$">
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <label for="">Impuesto</label>
                            <input type="text" name="taxes" id="taxes" class="form-control text-decoration-none" readonly="readonly" step="0.01" pattern="^\d+(\.\d{1,2})?$">
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
                <button type="button" class="btn btn-primary" onclick="confirmAsi('{{ route('storeretening') }}')">Confirmar</button>
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
<script src="{{asset('js/process/retention.js')}}"></script>
<script src="{{asset('js/process/accountcredit.js')}}"></script>
<script src="{{asset('js/process/accountdebit.js')}}"></script>
<script>
    function confirmAsi(url) {
        Swal.fire({
            title: 'Confirmación',
            text: '¿Crear el comprobante de Retención de I.V.A?',
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