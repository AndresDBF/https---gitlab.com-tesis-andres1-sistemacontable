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
                    @if ($payOrder->moneda != 'BS')
                        <input type="number" name="amountUnit" id="amountUnit" value="{{$detail->montounitariolocal}}" class="form-control text-decoration-none price-input text-center pb-2" readonly="readonly" tabindex="7"> 
                    @else
                        <input type="number" name="amountUnit" id="amountUnit" value="{{$detail->montounitariomoneda}}" class="form-control text-decoration-none price-input text-center pb-2" readonly="readonly" tabindex="7">
                    @endif
                    
                    <br>
                    @endforeach
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-pb-2">
                    <label for="" class="form-label text-center">Precio del Bien</label>
                    @foreach ($amountOrder as $detail)
                    @if ($payOrder->moneda != 'BS')
                        <input type="number" name="total-amount" id="total-amount" value="{{$detail->montobienlocal}}" class="form-control text-decoration-none total-amount text-center pb-2" readonly="readonly" tabindex="7" readonly>
                    @else
                        <input type="number" name="total-amount" id="total-amount" value="{{$detail->montobienmoneda}}" class="form-control text-decoration-none total-amount text-center pb-2" readonly="readonly" tabindex="7" readonly>  
                    @endif
                    
                    <br>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between ml-3 mr-5">
            <label class="fw-bold fs-4 me-auto">Monto Base Imponible</label>
            @if ($payOrder->moneda != 'BS')
                <label class="fw-bold ms-auto fs-4">{{$detailOrder->baseimponiblelocal}}</label>
            @else
                <label class="fw-bold ms-auto fs-4">{{$detailOrder->baseimponiblemoneda}}</label>
            @endif
        </div>   
        <div class="d-flex justify-content-between ml-3 mr-5">
            <label class="fw-bold fs-4 me-auto">Monto Total del IVA</label>
            @if ($payOrder->moneda != 'BS')
                <label class="fw-bold ms-auto fs-4">{{$detailOrder->montoivalocal}}</label>
            @else
                <label class="fw-bold ms-auto fs-4">{{$detailOrder->montoivamoneda}}</label>
            @endif
        </div>
        <div class="d-flex justify-content-between ml-3 mr-5">
            <label class="fw-bold fs-4 me-auto">Valor Total</label>
            @if ($payOrder->moneda != 'BS')
                <label class="fw-bold ms-auto fs-4">{{$detailOrder->montototallocal}}</label>
            @else
                <label class="fw-bold ms-auto fs-4">{{$detailOrder->montototalmoneda}}</label>
            @endif
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
