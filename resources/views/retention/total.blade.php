@extends('adminlte::page')

@section('title', 'Total Retención')

@section('content_header')
    <h1 class="fw-bold text-center">Confirmacion de Retención</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body pl-6">
        <div class="well">
            <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-pb-2">
                        <label for="" class="form-label text-center">Numero de Comprobante</label>
                        <input type="text" name="concept" id="concept" value="{{$retention->ncomprobante}}" class="form-control text-decoration-none text-center pb-2" readonly="readonly" tabindex="1">
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-pb-2">
                        <label for="" class="form-label text-center">Nombre del Sujeto Retenido</label>
                        <input type="text" name="amountUnit" id="amountUnit" value="{{$suject->nombre}}" class="form-control text-decoration-none price-input text-center pb-2" readonly="readonly" tabindex="2">
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-pb-2">
                        <label for="" class="form-label text-center">Fecha de Emisión</label>
                        <input type="text" name="total-amount" id="total-amount" value="{{$detRetention->fecemifact}}" class="form-control text-decoration-none total-amount text-center pb-2" readonly="readonly" tabindex="3" readonly>
                    </div>
            </div>
        </div>  
        <div class="d-flex justify-content-between ml-3 mr-5 mt-3">
            <label class="fw-bold fs-4 me-auto">Base Imponible</label>
            <label class="fw-bold ms-auto fs-4">{{$detRetention->baseimponible}}</label> 
        </div>
        <div class="d-flex justify-content-between ml-3 mr-5">
            <label class="fw-bold fs-4 me-auto">Monto Total del Impuesto</label>
            <label class="fw-bold ms-auto fs-4">{{$detRetention->montoimpuesto}}</label>
        </div>
        <div class="d-flex justify-content-between ml-3 mr-5">
            <label class="fw-bold fs-4 me-auto">Impuesto Retenido</label>
            <label class="fw-bold ms-auto fs-4">{{$detRetention->impuestoretenido}}</label>
        </div>                                        
    </div>
</div> 
@if (isset($retention->idrein))
    <a href="{{ route('retentionpdf', ['idret' => $retention->idrein,'inding' => $inding]) }}" class="btn btn-primary ml-2">Imprimir PDF</a>
    <a href="{{ route('listpay') }}" class="btn btn-primary ml-2">Aceptar</a>
@else
    <a href="{{ route('retentionpdf', ['idret' => $retention->idret,'inding' => $inding]) }}" class="btn btn-primary ml-2">Imprimir PDF</a>
    <a href="{{ route('listpay') }}" class="btn btn-primary ml-2">Aceptar</a>
@endif


@stop
