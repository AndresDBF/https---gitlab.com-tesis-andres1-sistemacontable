@extends('adminlte::page')

@section('title', 'Total Recibo de Pago')

@section('content_header')
    <h1 class="fw-bold text-center">Confirmacion de Recbio de Pago</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body pl-6">
        <div class="well">
            <div class="row">
               
                    <div class="col-xs-4 col-sm-4 col-md-4 col-pb-2">
                        <label for="" class="form-label text-center">Numero de Confirmacion</label>
                        <input type="text" name="concept" id="concept" value="{{$proofIncome->numconfirm}}" class="form-control text-decoration-none text-center pb-2" readonly="readonly" tabindex="7">
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-pb-2">
                        <label for="" class="form-label text-center">Nombre del Cliente</label>
                        <input type="text" name="amountUnit" id="amountUnit" value="{{$customer->nombre}}" class="form-control text-decoration-none price-input text-center pb-2" readonly="readonly" tabindex="7">
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-pb-2">
                        <label for="" class="form-label text-center">Moneda</label>
                        <input type="text" name="total-amount" id="total-amount" value="{{$proofIncome->moneda}}" class="form-control text-decoration-none total-amount text-center pb-2" readonly="readonly" tabindex="7" readonly>
                    </div>
            </div>
        </div>  
        @if ($proofIncome->moneda == 'BS')
            <div class="d-flex justify-content-between ml-3 mr-5 mt-3">
                <label class="fw-bold fs-4 me-auto">Monto Total del Pago ({{$proofIncome->moneda}})</label>
                <label class="fw-bold ms-auto fs-4">{{$proofIncome->mtolocal}}</label> 
            </div>
            <div class="d-flex justify-content-between ml-3 mr-5">
                <label class="fw-bold fs-4 me-auto">Monto Total del Impuesto IGTF ({{$proofIncome->moneda}})</label>
                <label class="fw-bold ms-auto fs-4">{{$proofIncome->montoigtflocal}}</label>
            </div>   
        @else
            <div class="d-flex justify-content-between ml-3 mr-5 mt-3">
                <label class="fw-bold fs-4 me-auto">Monto Total del Pago ({{$proofIncome->moneda}})</label>
                <label class="fw-bold ms-auto fs-4">{{$proofIncome->mtomoneda}}</label> 
            </div>
            <div class="d-flex justify-content-between ml-3 mr-5">
                <label class="fw-bold fs-4 me-auto">Monto Total del Impuesto IGTF ({{$proofIncome->moneda}})</label>
                <label class="fw-bold ms-auto fs-4">{{$proofIncome->montoigtfmoneda}}</label>
            </div>  
        @endif 
                                 
    </div>
</div> 

<a href="{{route('deleteproof',['idcom' => $idcom])}}">
    <button type="button" class="btn btn-secondary">Atras</button>
</a>
<a href="{{ route('proofinvoicepdf', ['idcom' => $idcom, 'idcli' => $idcli]) }}" class="btn btn-primary ml-2">Imprimir PDF</a>
<a href="{{ route('searchInvoice') }}" class="btn btn-primary ml-2">Aceptar</a>

@stop
