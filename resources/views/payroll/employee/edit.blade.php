@extends('adminlte::page')

@section('title', 'Editar Empleado')

@section('content_header')
    <h1 class="text-secondary fs-5 shadow-lg p-2 mb-5 bg-body rounded text-center">Editar Empleado</h1>
@stop

@section('content')
<div class="container"> 
    <div class="card">
        <div class="card-header">
            <h2 class="text-center"> Datos del Empleado</h2>
        </div>
        <div class="card-body pl-6">
            <form action="{{ route('payroll.update', ['payroll' => strval($employee->idnom ?? '')]) }}" method="POST">

             
                @csrf
                @method('PUT')
                <div class="mb-3">
                <label for="" class="form-label">Nombre del Empleado</label>
                @if($errors->first('name'))
                    <p class="text-danger">{{$errors->first('name')}}</p>
                @endif
                <input type="text" name="name" id="name" value="{{$employee->nombre}}" class="form-control" tabindex="2">
                </div>
                <div class="well">
                <div class="row">
                    <div class="col-xs-3 col-sm-6 col-md-4">
                        <div class="form-label">
                            <label for="dni">Tipo de Identificación</label>
                            @if($errors->first('tipid'))
                                <p class="text-danger">{{$errors->first('tipid')}}</p>
                            @endif
                            <select name="tipid" class="custom-select">
                                <option value="V" @if ($employee->tipid == 'V') selected @endif>V</option>
                                <option value="J" @if ($employee->tipid == 'J') selected @endif>J</option>
                                <option value="E" @if ($employee->tipid == 'E') selected @endif>E</option>
                            </select>
                            
                        </div>
                    </div>
                    <div class="col-xs-3 col-sm-6 col-md-4">
                        <label for="" class="form-label">Rif o Cedula del Proveedor</label>
                        <input type="number" name="identification" id="identification" value="{{$employee->identificacion}}" class="form-control text-decoration-none" tabindex="6">
                        @if($errors->first('identification'))
                            <p class="text-danger">{{$errors->first('identification')}}</p>
                        @endif
                    </div>
                    <div class="col-xs-3 col-sm-6 col-md-4" id="div-off">
                        <label for="" class="form-label">Digito Verificador</label>

                        <select name="numdig" class="custom-select">
                            <option value="{{$employee->tiprif}}">{{$employee->tiprif}}</option>
                            @for ($i = 0; $i < 9; $i++)
                                @if ($employee->tiprif == $i)
                                    @continue
                                @endif
                                <option value="{{$i}}">{{$i}}</option>
                            @endfor
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
                            <input type="text" name="phone" id="phone" value="{{$employee->telefono}}" class="form-control" tabindex="4">
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <label for="" class="form-label">Correo Electronico</label>
                            @if($errors->first('email'))
                                <p class="text-danger">{{$errors->first('email')}}</p>
                            @endif
                            <input type="text" name="email" id="email" value="{{$employee->correo}}" class="form-control" tabindex="5">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="" class="well-lg form-label">Dirección</label>
                    @if($errors->first('direction'))
                        <p class="text-danger">{{$errors->first('direction')}}</p>
                    @endif
                    <input type="text" name="direction" id="" value="{{$employee->direccion}}"  class="form-control" tabindex="6"></textarea>
                
                </div>

                <div class="well">
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <label for="" class="well-lg form-label">Cargo del Empleado</label>
                            <select name="tipcarg" class="custom-select">
                                <option value="{{$chargeEmployee->idcarg}}">{{$chargeEmployee->concepto_cargo}}</option>
                                @if ($charges != null)
                                    @foreach ($charges as $char)
                                        <option value="{{$char->idcarg}}">{{$char->concepto_cargo}}</option>
                                    @endforeach
                                @endif
                            
                            </select>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <label for="" class="well-lg form-label">Fecha de Ingreso</label>
                            <input type="text" class="form-control" value="{{$employee->fec_ingr}}" name="fec_ing" readonly>
                        </div>
                    </div>
                </div>
                <div class="well pb-3 mt-3">
                    <a href="/payroll" class="btn btn-secondary" tabindex="5">Atras</a>
                    <button type="submit" class="btn btn-primary"  >Aceptar</button>  
                </div> 
            </form>
        </div>
    </div>
    
</div>
@stop

@section('js')

@endsection