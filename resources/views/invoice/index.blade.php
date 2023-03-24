@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="container"> 
        <div class="card">
            <div class="card-body pl-6">
                <form action="{{route('invoiceing')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Numero de Relacion de ingreso</label>
                        <input type="text" name="numreling" id="code" class="form-control" readonly="readonly" value="{{$idcfact}}" tabindex="1">
                    </div>
                    <div class="well">
                        <div class="row">
                            <div class="col-xs-3 col-sm-6 col-md-6">
                                <label for="" class="form-label">Numero de Factura</label>
                                <input type="text" name="numfact" id="numfact" class="form-control" tabindex="2">
                            </div>
                            <div class="col-xs-3 col-sm-6 col-md-6">
                                <label for="" class="form-label">Control de Factura</label>
                                <input type="text" name="numctrl" id="numctrl" class="form-control" tabindex="3">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Nombre y Apellido o Razon Social</label>
                        <input type="text" name="name" id="name" class="form-control" tabindex="4">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Direccion de Factura</label>
                        <input type="text" name="direction" id="direction" class="form-control" tabindex="5">
                    </div>
                    <div class="well">
                        <div class="row">
                            <div class="col-xs-3 col-sm-6">
                                <label for="" class="form-label">Rif o Cedula del Cliente</label>
                                <input type="number" name="identification" id="identification" class="form-control text-decoration-none" tabindex="6">
                            </div>
                            <div class="col-xs-3 col-sm-6">
                                <label for="" class="form-label">Telefono</label>
                                <input type="number" name="phone" id="phone" class="form-control text-decoration-none" tabindex="7">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Forma de Pago</label>
                        <input type="text" name="waytopay" id="waytopay" class="form-control" tabindex="8">
                    </div>
                </form> 
            </div>
        </div>   

        <div class="card">
            <div class="card-body pl-6">
                <form action="{{route('cinvoiceing')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Numero de Relacion de ingreso</label>
                        <input type="text" name="numreling" id="code" class="form-control" readonly="readonly" value="" tabindex="1">
                    </div>
                    <div class="well">
                        <div class="row">
                            <div class="col-xs-3 col-sm-6 col-md-6">
                                <label for="" class="form-label">Numero de Factura</label>
                                <input type="text" name="numfact" id="numfact" class="form-control" tabindex="2">
                            </div>
                            <div class="col-xs-3 col-sm-6 col-md-6">
                                <label for="" class="form-label">Control de Factura</label>
                                <input type="text" name="numctrl" id="numctrl" class="form-control" tabindex="3">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Nombre y Apellido o Razon Social</label>
                        <input type="text" name="name" id="name" class="form-control" tabindex="4">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Direccion de Factura</label>
                        <input type="text" name="direction" id="direction" class="form-control" tabindex="5">
                    </div>
                    <div class="well">
                        <div class="row">
                            <div class="col-xs-3 col-sm-6">
                                <label for="" class="form-label">Rif o Cedula del Cliente</label>
                                <input type="number" name="identification" id="identification" class="form-control text-decoration-none" tabindex="6">
                            </div>
                            <div class="col-xs-3 col-sm-6">
                                <label for="" class="form-label">Telefono</label>
                                <input type="number" name="phone" id="phone" class="form-control text-decoration-none" tabindex="7">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Forma de Pago</label>
                        <input type="text" name="waytopay" id="waytopay" class="form-control" tabindex="8">
                    </div>
                </form> 
            </div>
        </div>     
    </div>
@stop