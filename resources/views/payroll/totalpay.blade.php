@extends('adminlte::page')

@section('title', 'Total Pago de Nomina')

@section('content_header')
    <h1 class="fw-bold text-center">Confirmacion de Pago de Nomina</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body pl-6">
        <div class="well">
            <div class="row">
                <div class="col-xs-2 col-sm-2 col-md-2 col-pb-2">
                    <label for="" class="form-label text-center">Fecha de Ingreso</label>
                    <input type="text" name="concept" id="concept" value="{{$totalpay->fecpag}}" class="form-control text-decoration-none text-center pb-2" readonly="readonly" tabindex="7">
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-pb-4">
                    <label for="" class="form-label text-center">Nombre del Empleado</label>
                    <input type="text" name="concept" id="concept" value="{{$employee->nombre}}" class="form-control text-decoration-none text-center pb-2" readonly="readonly" tabindex="7">
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-pb-4">
                    <label for="" class="form-label text-center">Cargo del Empleado</label>
                    <input type="text" name="amountUnit" id="amountUnit" value="{{$tipcarg->concepto_cargo}}" class="form-control text-decoration-none price-input text-center pb-2" readonly="readonly" tabindex="7">
                </div>
                <div class="col-xs-2 col-sm-2 col-md-2 col-pb-2">
                    <label for="" class="form-label text-center">Dias Trabajados</label>
                    <input type="text" name="total-amount" id="total-amount" value="{{$dayst}}" class="form-control text-decoration-none total-amount text-center pb-2" readonly="readonly" tabindex="7" readonly>
                </div> 
            </div>
        </div> 

            <div class="d-flex justify-content-between ml-3 mr-5 mt-3">
                <label class="fw-bold fs-4 me-auto">Monto Total Asignado</label>
                <label class="fw-bold ms-auto fs-4">{{$totalpay->totalasignacion}}</label> 
            </div>
            <div class="d-flex justify-content-between ml-3 mr-5">
                <label class="fw-bold fs-4 me-auto">Monto Total a Cobrar</label>
                <label class="fw-bold ms-auto fs-4">{{$totalpay->netocobrar}}</label>
            </div>                                    
    </div>
</div> 


<a href="{{ route('proofemployee', ['idnom' => $idnom, 'idtnom' => $idtnom, 'fecpag' => $fecpag, 'dayst' => $dayst]) }}" class="btn btn-primary ml-2">Imprimir Recibo de Empleado</a>
<a href="/payroll" class="btn btn-primary ml-2">Aceptar</a>

@stop
