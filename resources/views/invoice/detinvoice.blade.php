@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="container"> 
        <div class="card">
            <div class="card-body pl-6">
                <form action="{{route('storeinvoice')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Numero de Relacion de ingreso</label>
                        <input type="text" name="numreling" id="numreling" class="form-control" readonly="readonly" value="{{$invoice->numreling}}" tabindex="1">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Nombre y Apellido o Razon Social</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{$invoice->nomacre}}" tabindex="4">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Direccion de Factura</label>
                        <input type="text" name="direction" id="direction" value="{{$invoice->direccion}}" class="form-control" tabindex="5">
                    </div>
                    <div class="well">
                        <div class="row">
                            <div class="col-xs-3 col-sm-6 col-md-4">
                                <div class="form-label">
                                    <label for="dni">Tipo de Identificación</label>
                                    <select name = 'tipid' class="custom-select">
                                        <option selected="">Seleccionar Identificación</option>
                                        <option value="V">V</option>
                                        <option value="J">J</option>
                                        <option value="E">E</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-3 col-sm-6 col-md-4">
                                <label for="" class="form-label">Rif o Cedula del Cliente</label>
                                <input type="number" name="identification" id="identification" value="{{$invoice->identificacion}}" class="form-control text-decoration-none" tabindex="6">
                            </div>
                            <div class="col-xs-3 col-sm-6 col-md-4">
                                <label for="" class="form-label">Numero de Chequeo</label>
                                <select name = 'tiprif' class="custom-select">
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
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Telefono</label>
                        <input type="number" name="phone" id="phone" value="{{$invoice->telefono}}" class="form-control text-decoration-none" tabindex="7">
                    </div>
                    <div class="col-xs-6 col-sm-6">
                        <div class="form-group">
                          <label for="dni">Tipo de Pago</label>
                          <select name = 'tip_pag' class="custom-select">
                            <option selected="">Selecciona un tipo de pago</option>
                              @foreach ($tippag as $tip)
                                  <option value="{{$tip->tippago}}">{{$tip->descripcion}}</option>
                              @endforeach
                          </select>
                        </div>
                    </div>
                </form> 
            </div>
        </div>   

        <div class="card">
            <div class="card-body pl-6">
                <form action="{{route('storeinvoice')}}" method="POST">
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