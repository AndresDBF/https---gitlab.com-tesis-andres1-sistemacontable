@extends('adminlte::page')

@section('title', 'Nuevo Empleado')

@section('content_header')
    <h1 class="text-secondary fs-5 shadow-lg p-2 mb-5 bg-body rounded text-center">Nuevo Empleado</h1>
@stop

@section('content')
<div class="container"> 
    <form action="/payroll" method="POST">
    @csrf
        <div class="card">
            <div class="card-header">
                <h2 class="text-center"> Datos del Empleado</h2>
            </div>
            <div class="card-body pl-6">
            
                <div class="mb-3">
                <label for="" class="form-label">Nombre del Empleado</label>
                @if($errors->first('name'))
                    <p class="text-danger">{{$errors->first('name')}}</p>
                @endif
                <input type="text" name="name" id="name" class="form-control" tabindex="1">
                </div>
                <div class="well">
                <div class="row">
                    <div class="col-xs-3 col-sm-6 col-md-4">
                        <div class="form-label">
                            <label for="dni">Tipo de Identificación</label>
                            @if($errors->first('tipid'))
                                <p class="text-danger">{{$errors->first('tipid')}}</p>
                            @endif
                            <select name = 'tipid' class="custom-select">
                                <option selected="">Seleccionar Identificación</option>
                                <option value="V">V</option>
                                <option value="J">J</option>
                                <option value="E">E</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-3 col-sm-6 col-md-4">
                        <label for="" class="form-label">Rif o Cedula del Proveedor</label>
                        <input type="number" name="identification" id="identification" class="form-control text-decoration-none" tabindex="2">
                        @if($errors->first('identification'))
                            <p class="text-danger">{{$errors->first('identification')}}</p>
                        @endif
                    </div>
                    <div class="col-xs-3 col-sm-6 col-md-4" id="div-off">
                        <label for="" class="form-label">Digito Verificador</label>
                        <select name = 'tiprif' class="custom-select">
                            <option selected="">Seleccionar digito</option>
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
                <div class="well mt-2">
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <label for="" class="form-label">Telefono</label>
                            @if($errors->first('phone'))
                                <p class="text-danger">{{$errors->first('phone')}}</p>
                            @endif
                            <input type="text" name="phone" id="phone" class="form-control" tabindex="3">
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <label for="" class="form-label">Correo Electronico</label>
                            @if($errors->first('email'))
                                <p class="text-danger">{{$errors->first('email')}}</p>
                            @endif
                            <input type="text" name="email" id="email" class="form-control" tabindex="4">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="" class="well-lg form-label">Dirección</label>
                    @if($errors->first('direction'))
                        <p class="text-danger">{{$errors->first('direction')}}</p>
                    @endif
                    <textarea name="direction" id="" class="form-control" tabindex="5"></textarea>
                   
                </div>

                <div class="well">
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <label for="" class="well-lg form-label">Cargo del Empleado</label>
                            <select name="tipcarg" class="custom-select">
                                <option value="">Seleccionar Cargo</option>
                                @foreach ($charges as $char)
                                    <option value="{{$char->idcarg}}">{{$char->concepto_cargo}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <label for="" class="well-lg form-label">Fecha de Ingreso</label>
                            <input type="text" class="form-control" value="{{$fecing}}" name="fec_ing" readonly>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <label for="" class="well-lg form-label">Sueldo Mensual (BS)</label>
                    <input type="text" class="form-control" name="salary">
                </div>
            </div>
        </div>
        <div class="well pb-3 mt-3">
            <a href="/payroll" class="btn btn-secondary" tabindex="6">Atras</a>
            <button type="submit" class="btn btn-primary"  >Aceptar</button>  
        </div> 
    </form>
</div>
@stop

@section('js')
    <script src="{{asset('js/process/verifyidentification.js')}}"></script>
@endsection