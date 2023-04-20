@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Creació de Ingreso</h1>
@stop

@section('content')
<div class="container">
    @if(session('error'))
    <div class="alert alert-danger" role="alert">
        {{ session('error') }}
    </div>
    @endif
    <div class="card">
        <div class="card-body pl-6">
        <h3 class="text-center fw-bolder pb-4">Ingresa la Identificación del Beneficiario de la Factura</h3>
            <div class="well">
                <div class="row">
                    <div class="col-xs-3 col-sm-6 col-md-4">
                        <div class="form-label">
                            <label for="dni">Tipo de Identificación</label>
                            <select name = 'tipid' class="custom-select">
                                @if ($invoice->tipid == 'V')
                                    <option value="V">V</option>
                                    <option value="J">J</option>
                                    <option value="E">E</option>
                                @elseif($invoice->tipid == 'J')
                                    <option value="J">J</option>
                                    <option value="V">V</option>
                                    <option value="E">E</option>
                                @elseif($invoice->tipid == 'E')
                                <option value="E">E</option>
                                <option value="V">V</option>
                                <option value="E">E</option>
                                @else
                                    <option selected="">Seleccionar Identificación</option>
                                    <option value="V">V</option>
                                    <option value="J">J</option>
                                    <option value="E">E</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-3 col-sm-6 col-md-4">
                        <label for="" class="form-label">Rif o Cedula del Cliente</label>
                        <input type="number" name="identification" value="{{$invoice->identificacion}}" id="identification" class="form-control text-decoration-none">
                    </div>
                    <div class="col-xs-3 col-sm-6 col-md-4">
                        <label for="" class="form-label">Numero de Chequeo</label>
                        <select name = 'numcheck' class="custom-select">
                            @if ($invoice->tiprif == null)
                                <option selected="">Seleccionar Numero</option>
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>                               
                            @else
                                @for ($i = 0; $i < 10; $i++)
                                    @if ($i == $invoice->tiprif)
                                        <option value="{{$i}}" selected>{{$i}}</option>
                                    @endif
                                    <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            
                            @endif
                            
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body pl-6">
        <h3 class="text-center fw-bolder">Comprobante de Ingreso</h3>
        <form action="{{route('storeIncome')}}" method="POST" id="myform">
            @csrf
            <div class="well">
                <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <label for="" class="form-label">Fecha de Transacción</label>
                        <input type="text" name="fecTransiction" value="{{$fecTransaction}}" id="fecTransiction" readonly="readonly" class="form-control text-decoration-none text-center">
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <label for="" class="form-label">Numero de Confirmación</label>
                        <input type="text" name="numconfirm" id="numconfirm" class="form-control text-decoration-none" tabindex="1">
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <label for="" class="form-label">Numero de factura</label>
                        <input type="text" name="numfact" id="numfact" value="{{$detInvoice->numfact}}" readonly="readonly" class="form-control text-decoration-none">
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Nombre y Apellido o Razon Social</label>
                <input type="text" name="name" id="name" value="{{$invoice->nomacre}}" class="form-control" readonly="readonly">
            </div>
            <div class="well">
                <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <label for="" class="">Forma de Pago</label>
                        <select name="formPay" class="custom-select">
                            <option value="" tabindex="2">Seleccionar Forma de Pago</option>
                            @foreach ($formPay as $pay)
                                <option value="{{$pay->tippago}}">{{$pay->descripcion}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <label for="" class="form-label">Moneda</label>
                        <select name = 'money' class="custom-select">
                           <option selected="" tabindex="3" >Seleccionar Moneda</option>
                           @foreach ($money as $tipmoney)
                               <option value="{{$tipmoney->tipmoneda}}">{{$tipmoney->descripcion}}</option>
                           @endforeach
                        </select>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <label for="" class="form-label">Cantidad</label>
                        <input type="text" name="amount" id="amount" class="form-control" tabindex="4">
                    </div>
                </div>
            </div>
            <div class="mb-3 mt-3">
                <label for="" class="form-label">Por Concepto de</label>
                <input type="text" name="byconcept" id="byconcept" class="form-control" tabindex="5">
            </div>
            <div class="mb-3 mt-3">
                <label for="" class="form-label">Descripción de Comprobante de Ingreso</label>
                <textarea class="form-control" name="description" id="description" tabindex="6"></textarea>
            </div>
            <div class="well pb-3 mt-3">
                <a href="{{route('searchInvoice')}}">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Atras</button>
                </a>
                <button type="submit" class="btn btn-primary" id="submitForm">Aceptar</button>
            </div>
        </form>
    </div>
</div>
@stop