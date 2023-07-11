@extends('adminlte::page')

@section('title', 'Total Factura')

@section('content_header')
    <h1 class="fw-bold text-center">Confirmacion de Facturacion</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body pl-6">
        <div class="well">
            <div class="row">
                @if ($invoice->moneda == 'BS')
                    <div class="col-xs-4 col-sm-4 col-md-4 col-pb-2">
                        <label for="" class="form-label text-center">Concepto de factura</label>
                        @foreach ($descFact as $desc)
                            <input type="text" name="concept" id="concept" value="{{$desc->descripcion}}" class="form-control text-decoration-none text-center pb-2" readonly="readonly" tabindex="7">
                            <br>
                        @endforeach
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-pb-2">
                        <label for="" class="form-label text-center">Precio Unitario</label>
                        @foreach ($descFact as $desc)
                        <input type="number" name="amountUnit" id="amountUnit" value="{{$desc->monto_unitariolocal}}" class="form-control text-decoration-none price-input text-center pb-2" readonly="readonly" tabindex="7">
                        <br>
                        @endforeach
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-pb-2">
                        <label for="" class="form-label text-center">Precio del Bien</label>
                        @foreach ($descFact as $desc)
                        <input type="number" name="total-amount" id="total-amount" value="{{$desc->monto_bienlocal}}" class="form-control text-decoration-none total-amount text-center pb-2" readonly="readonly" tabindex="7" readonly>
                        <br>
                        @endforeach
                    </div>
                @else
                    <div class="col-xs-4 col-sm-4 col-md-4 col-pb-2">
                        <label for="" class="form-label text-center">Concepto de factura</label>
                        @foreach ($descFact as $desc)
                            <input type="text" name="concept" id="concept" value="{{$desc->descripcion}}" class="form-control text-decoration-none text-center pb-2" readonly="readonly" tabindex="7">
                            <br>
                        @endforeach
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-pb-2">
                        <label for="" class="form-label text-center">Precio Unitario</label>
                        @foreach ($descFact as $desc)
                        <input type="number" name="amountUnit" id="amountUnit" value="{{$desc->monto_unitariomoneda}}" class="form-control text-decoration-none price-input text-center pb-2" readonly="readonly" tabindex="7">
                        <br>
                        @endforeach
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-pb-2">
                        <label for="" class="form-label text-center">Precio del Bien</label>
                        @foreach ($descFact as $desc)
                        <input type="number" name="total-amount" id="total-amount" value="{{$desc->monto_bienmoneda}}" class="form-control text-decoration-none total-amount text-center pb-2" readonly="readonly" tabindex="7" readonly>
                        <br>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>  
        @if ($invoice->moneda == 'BS')
            <div class="d-flex justify-content-between ml-3 mr-5 mt-3">
                <label class="fw-bold fs-4 me-auto">Monto Total de la Base Imponible al Valor Agregado ({{$invoice->moneda}})</label>
                <label class="fw-bold ms-auto fs-4">{{$baseImponiblelocal}}</label> 
            </div>
            <div class="d-flex justify-content-between ml-3 mr-5">
                <label class="fw-bold fs-4 me-auto">Monto Total del Impuesto al Valor Agregado ({{$invoice->moneda}})</label>
                <label class="fw-bold ms-auto fs-4">{{$totalImpuestolocal}}</label>
            </div>
            <div class="d-flex justify-content-between ml-3 mr-5">
                <label class="fw-bold fs-4 me-auto">Valor Total de la Venta ({{$invoice->moneda}})</label>
                <label class="fw-bold ms-auto fs-4">{{$totalFactlocal}}</label>
            </div>       
        @else
            <div class="d-flex justify-content-between ml-3 mr-5 mt-3">
                <label class="fw-bold fs-4 me-auto">Monto Total de la Base Imponible al Valor Agregado ({{$invoice->moneda}})</label>
                <label class="fw-bold ms-auto fs-4">{{$baseImponiblemoneda}}</label> 
            </div>
            <div class="d-flex justify-content-between ml-3 mr-5">
                <label class="fw-bold fs-4 me-auto">Monto Total del Impuesto al Valor Agregado ({{$invoice->moneda}})</label>
                <label class="fw-bold ms-auto fs-4">{{$totalImpuestomoneda}}</label>
            </div>
            <div class="d-flex justify-content-between ml-3 mr-5">
                <label class="fw-bold fs-4 me-auto">Valor Total de la Venta ({{$invoice->moneda}})</label>
                <label class="fw-bold ms-auto fs-4">{{$totalFactmoneda}}</label>
            </div>    
        @endif 
                                 
    </div>
</div> 

<a href="{{route('deleteInvoice',['idfact'=>$idfact])}}">
    <button type="button" class="btn btn-secondary">Atras</button>
</a>
<a href="{{ route('invoicepdf', ['idfact' => $idfact, 'idcli' => $idcli]) }}" class="btn btn-primary ml-2">Imprimir Factura</a>
<a href="{{ route('findcustomer') }}" class="btn btn-primary ml-2">Aceptar</a>

@stop
