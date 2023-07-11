@extends('adminlte::page')

@section('title', 'Total Registro de Pago')

@section('content_header')
    <h1 class="fw-bold text-center">Confirmacion de Registro de Pago</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body pl-6">
        <div class="well">
            <div class="row">
                <div class="col-xs-2 col-sm-2 col-md-2 col-pb-2">
                    <label for="" class="form-label text-center">Fecha de Emisión</label>
                    <input type="text" name="concept" id="concept" value="{{$payorder->fec_emi}}" class="form-control text-decoration-none text-center pb-2" readonly="readonly" tabindex="7">
                </div>
                <div class="col-xs-2 col-sm-2 col-md-2 col-pb-2">
                    <label for="" class="form-label text-center">Numero de Factura</label>
                    <input type="text" name="concept" id="concept" value="{{$payorder->numfact}}" class="form-control text-decoration-none text-center pb-2" readonly="readonly" tabindex="7">
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-pb-4">
                    <label for="" class="form-label text-center">Nombre del Cliente</label>
                    <input type="text" name="amountUnit" id="amountUnit" value="{{$supplier->nombre}}" class="form-control text-decoration-none price-input text-center pb-2" readonly="readonly" tabindex="7">
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-pb-4">
                    <label for="" class="form-label text-center">Moneda</label>
                    <input type="text" name="total-amount" id="total-amount" value="{{$payorder->moneda}}" class="form-control text-decoration-none total-amount text-center pb-2" readonly="readonly" tabindex="7" readonly>
                </div>
            </div>
        </div>  
        @if ($payorder->moneda == 'BS')
            <div class="d-flex justify-content-between ml-3 mr-5 mt-3">
                <label class="fw-bold fs-4 me-auto">Base Imponible Total ({{$payorder->moneda}})</label>
                <label class="fw-bold ms-auto fs-4">{{$payorder->baseimponiblelocal}}</label> 
            </div>
            @if ($payorder->indiva == 'S')
                <div class="d-flex justify-content-between ml-3 mr-5 mt-2">
                    <label class="fw-bold fs-4 me-auto">Impuesto al valor Agregado I.V.A ({{$payorder->moneda}})</label>
                    <label class="fw-bold ms-auto fs-4">{{$payorder->montoivalocal}}</label> 
                </div>
            @else
                <div class="d-flex justify-content-between ml-3 mr-5 mt-2">
                    <label class="fw-bold fs-4 me-auto">Impuesto al valor Agregado I.V.A ({{$payorder->moneda}})</label>
                    <label class="fw-bold ms-auto fs-4">0</label> 
                </div>
            @endif 
            <div class="d-flex justify-content-between ml-3 mr-5">
                <label class="fw-bold fs-4 me-auto">Monto Total del Egreso ({{$payorder->moneda}})</label>
                <label class="fw-bold ms-auto fs-4">{{$payorder->montototallocal}}</label>
            </div>   

        @else
            <div class="d-flex justify-content-between ml-3 mr-5 mt-2">
                <label class="fw-bold fs-4 me-auto">Base Imponible Total ({{$payorder->moneda}})</label>
                <label class="fw-bold ms-auto fs-4">{{$payorder->baseimponiblemoneda}}</label> 
            </div>
            @if ($payorder->indiva == 'S')
                <div class="d-flex justify-content-between ml-3 mr-5 mt-2">
                    <label class="fw-bold fs-4 me-auto">Impuesto al valor Agregado I.V.A ({{$payorder->moneda}})</label>
                    <label class="fw-bold ms-auto fs-4">{{$payorder->montoivamoneda}}</label> 
                </div>
            @else
                <div class="d-flex justify-content-between ml-3 mr-5 mt-2">
                    <label class="fw-bold fs-4 me-auto">Impuesto al valor Agregado I.V.A ({{$payorder->moneda}})</label>
                    <label class="fw-bold ms-auto fs-4">0</label> 
                </div>
            @endif 
            <div class="d-flex justify-content-between ml-3 mr-5">
                <label class="fw-bold fs-4 me-auto">Monto Total del Ingreso ({{$payorder->moneda}})</label>
                <label class="fw-bold ms-auto fs-4">{{$payorder->montototalmoneda}}</label>
            </div>  
        @endif 
                                 
    </div>
</div> 


<a href="{{ route('relegrepdf', ['idorpa' => $idorpa, 'idprov' => $idprov]) }}" class="btn btn-primary ml-2">Reporte Egresos del Proveedor</a>
<a href="{{ route('registerpay') }}" class="btn btn-primary ml-2">Aceptar</a>

@stop
