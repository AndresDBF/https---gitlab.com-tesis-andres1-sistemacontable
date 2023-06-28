@extends('adminlte::page')

@section('title', 'Cargos de empleados')

@section('content_header')
    <h1>Cargos de Empleados</h1>
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    Crear Cargo de Empleado
                </div>
                <div class="card-body">
                    <form action="{{ route('chargesStore') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre del Cargo</label>
                            @if($errors->first('concepto_cargo'))
                                <p class="text-danger">{{$errors->first('concepto_cargo')}}</p>
                            @endif
                            <input type="text" class="form-control" id="concepto_cargo" name="concepto_cargo" required>
                        </div>
                        <div class="mb-3">
                            <label for="tipcarg" class="form-label">Tipo de Cargo</label>
                            <select name="tipcargo" class="custom-select">
                                <option value="AGE">Agente</option>
                                <option value="ADM">Administrador</option>
                                <option value="CON">Contador</option>
                                <option value="DIR">Director</option>
                                <option value="DIG">Diseñador Gráfico</option>
                                <option value="GER">Gerente</option>
                                <option value="PRO">Programador</option>
                                <option value="IT">Soporte Tecnico</option>
                                <option value="SUP">Supervisor</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="salary" class="form-label">Sueldo (BS)</label>
                            @if($errors->first('sueldo_cargo'))
                                <p class="text-danger">{{$errors->first('sueldo_cargo')}}</p>
                            @endif
                            <input type="number" class="form-control" id="sueldo_cargo" name="sueldo_cargo" step="0.01" pattern="^\d+(\.\d{1,2})?$">
                        </div>
                        <a href="/payroll">
                            <button type="button" class="btn btn-secondary">Cancelar</button>
                        </a>
                        <button type="submit" class="btn btn-primary">Crear Cargo</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
