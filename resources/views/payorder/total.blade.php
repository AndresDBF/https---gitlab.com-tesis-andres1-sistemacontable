@extends('adminlte::page')

@section('title', 'Orden de Compra')

@section('content_header')
<h1 class="fw-bold text-center">Confirmacion de Orden de Pago</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body pl-6">
        <div class="well">
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 col-pb-2">
                    <label for="" class="form-label text-center">Concepto de factura</label>
                    @foreach ($amountOrder as $detail)
                        <input type="text" name="concept" id="concept" value="{{$detail->descripcion}}" class="form-control text-decoration-none text-center pb-2" readonly="readonly" tabindex="7">
                        <br>
                    @endforeach
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-pb-2">
                    <label for="" class="form-label text-center">Precio Unitario</label>
                    @foreach ($amountOrder as $detail)
                    <input type="number" name="amountUnit" id="amountUnit" value="{{$detail->monto_unitario}}" class="form-control text-decoration-none price-input text-center pb-2" readonly="readonly" tabindex="7">
                    <br>
                    @endforeach
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-pb-2">
                    <label for="" class="form-label text-center">Precio del Bien</label>
                    @foreach ($amountOrder as $detail)
                    <input type="number" name="total-amount" id="total-amount" value="{{$detail->monto_bien}}" class="form-control text-decoration-none total-amount text-center pb-2" readonly="readonly" tabindex="7" readonly>
                    <br>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between ml-3 mr-5">
            <label class="fw-bold fs-4 me-auto">Monto Base Imponible</label>
            <label class="fw-bold ms-auto fs-4">{{$detailOrder->baseimponible}}</label>
        </div>   
        <div class="d-flex justify-content-between ml-3 mr-5">
            <label class="fw-bold fs-4 me-auto">Monto Total del IVA</label>
            <label class="fw-bold ms-auto fs-4">{{$detailOrder->monto_iva}}</label>
        </div>
        <div class="d-flex justify-content-between ml-3 mr-5">
            <label class="fw-bold fs-4 me-auto">Valor Total</label>
            <label class="fw-bold ms-auto fs-4">{{$detailOrder->monto_total}}</label>
        </div>                             
    </div>
</div> 

<a href="{{route('deletedetorderpa',['idorpa'=>$idorpa])}}">
    <button type="button" class="btn btn-secondary">Atras</button>
</a>
<a href="{{route('home')}}">
    <button type="button" class="btn btn-primary ml-2">Aceptar</button>
    </a>
@stop
