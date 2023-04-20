@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1 class="fw-bold text-center">Confirmacion de Facturacion</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body pl-6">
        <div class="well">
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 col-pb-2">
                    <label for="" class="form-label text-center">Concepto de factura</label>
                    @foreach ($totalFact as $concept)
                        <input type="text" name="concept" id="concept" value="{{$concept->descripcion}}" class="form-control text-decoration-none text-center pb-2" readonly="readonly" tabindex="7">
                        <br>
                    @endforeach
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-pb-2">
                    <label for="" class="form-label text-center">Precio Unitario</label>
                    @foreach ($totalFact as $concept)
                    <input type="number" name="amountUnit" id="amountUnit" value="{{$concept->monto_unitario}}" class="form-control text-decoration-none price-input text-center pb-2" readonly="readonly" tabindex="7">
                    <br>
                    @endforeach
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-pb-2">
                    <label for="" class="form-label text-center">Precio del Bien</label>
                    @foreach ($totalFact as $concept)
                    <input type="number" name="total-amount" id="total-amount" value="{{$concept->monto_bien}}" class="form-control text-decoration-none total-amount text-center pb-2" readonly="readonly" tabindex="7" readonly>
                    <br>
                    @endforeach
                </div>
            </div>
        </div>   
        <div class="d-flex justify-content-between ml-3 mr-5 mt-3">
            <label class="fw-bold fs-4 me-auto">Monto Total de la Base Imponible al Valor Agregado</label>
            <label class="fw-bold ms-auto fs-4">{{$montoImponible}}</label> 
        </div>
        <div class="d-flex justify-content-between ml-3 mr-5">
            <label class="fw-bold fs-4 me-auto">Monto Total del Impuesto al Valor Agregado</label>
            <label class="fw-bold ms-auto fs-4">{{$montoImpuesto}}</label>
        </div>
        <div class="d-flex justify-content-between ml-3 mr-5">
            <label class="fw-bold fs-4 me-auto">Valor Total de la Venta</label>
            <label class="fw-bold ms-auto fs-4">{{$totalFactura}}</label>
        </div>                             
    </div>
</div> 

<a href="{{route('deleteInvoice',['idfact'=>$idfact])}}">
    <button type="button" class="btn btn-secondary">Atras</button>
</a>
<a href="{{route('home')}}">
    <button type="button" class="btn btn-primary ml-2">Aceptar</button>
    </a>
@stop