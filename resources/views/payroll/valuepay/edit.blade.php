@extends('adminlte::page')

@section('title', 'Valores de Pago')

@section('content_header')
    <h1>Valores de Pago</h1>
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    Crear Valor de Pago
                </div>
                <div class="card-body">
                    <form action="{{ route('valueupdate', $valuePay->idval) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Concepto de Pago</label>
                            @if($errors->first('concepto_valor'))
                                <p class="text-danger">{{$errors->first('concepto_valor')}}</p>
                            @endif
                            <input type="text" class="form-control" value="{{$valuePay->concepto_valor}}" id="concepto_valor" name="concepto_valor">
                        </div>                        
                        <div class="mb-3">
                            <label for="salary" class="form-label">Sueldo BS</label>
                            @if($errors->first('monto_valor'))
                                <p class="text-danger">{{$errors->first('monto_valor')}}</p>
                            @endif
                            <input type="number" class="form-control" id="monto_valor" value="{{$valuePay->monto_valor}}" name="monto_valor" step="0.01" pattern="^\d+(\.\d{1,2})?$">
                        </div>
                        <input type="hidden" name="fecsts" value="{{$fecsts}}">
                        <a href="/payroll">
                            <button type="button" class="btn btn-secondary">Cancelar</button>
                        </a>
                        <button type="submit" class="btn btn-primary">Actualizar Cargo</button>
                    </form>                    
                </div>
            </div>
        </div>
    </div>
</div>
@stop
