@extends('adminlte::page')

@section('title', 'Orden de Compra')

@section('content_header')
    <h1 class="text-secondary fs-5 shadow-lg p-2 mb-5 bg-body rounded text-center">Nueva Orden de Compra</h1>
@stop

@section('content')
<div class="container"> 
  <form action="{{route('storedetorder')}}" method="POST">
    <div class="card">
      <div class="card-body pl-6">
          @csrf
            <input type="hidden" name="idorco" id="idorco" value="{{$purchase->idorco}}">
            <div class="mb-3">
              <label for="" class="form-label">Numero de Orden</label>
              <input type="numeric" name="numorder" id="numorder" value ="{{$purchase->numorden}}" class="form-control" readonly="readonly">
            </div>
            <div class="mb-3">
              <label for="" class="form-label">Nombre del Proveedor</label>
              <input type="text" name="name" id="name" value ="{{$supplier->nombre}}" class="form-control" readonly="readonly">
            </div>
            <div class="well">
              <div class="row">
                  <div class="col-xs-3 col-sm-6 col-md-4">
                      <div class="form-label">
                          <label for="dni">Tipo de Identificación</label>
                          <input type="text" name="tipid" class="form-control text-decoration-none" value="{{$supplier->tipid}}" readonly="readonly">
                      </div>
                  </div>
                  <div class="col-xs-3 col-sm-6 col-md-4">
                      <label for="" class="form-label">Rif o Cedula del Proveedor</label>
                      <input type="number" name="identification" id="identification" value="{{$supplier->identificacion}}" class="form-control text-decoration-none" readonly="readonly">
                  </div>
                  @if ($supplier->tipid != null)
                    <div class="col-xs-3 col-sm-6 col-md-4" id="div-off">
                      <label for="" class="form-label">Digito Verificador</label>
                      <input type="text" name="tiprif" class="form-control text-decoration-none" value="{{$supplier->tiprif}}" readonly="readonly">
                    </div>
                  @endif
              </div>
            </div>
            <div class="well">
              <div class="row">
                <div class="col-xs-3 col-sm-6 col-md-4">
                  <label for="" class="form-label">Telefono</label>
                  <input type="text" name="phone" id="phone" value="{{$supplier->telefono}}" class="form-control" readonly="readonly">
                </div>
                <div class="col-xs-3 col-sm-6 col-md-4">
                  <label for="dni">Categoria</label>
                  <input type="text" name="category"  class="form-control text-decoration-none" value="{{$supplier->categoria}}" readonly="readonly">
                </div>
                <div class="col-xs-3 col-sm-6 col-md-4">
                  <label for="" class="form-label">Correo Electronico</label>
                  <input type="text" name="email" id="email" value="{{$supplier->correo}}" class="form-control" readonly="readonly">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="" class="well-lg form-label">Dirección</label>
              <input type="text" name="direction" id="direction" value="{{$supplier->direccion}}" class="form-control" readonly="readonly">
            </div>

      </div>
    </div>
    <div class="card">
        <div class="card-body pl-6">
            <div class="well">
                <div class="row">
                    <div class="col-xs-3 col-sm-6 col-md-4">
                        <label for="" class="well-lg form-label">Dias de Plazo de Pago</label>
                        <input type="numeric" name="days" id="days" value="{{$purchase->tiempo_pago}}" class="form-control" readonly="readonly">
                    </div>
                    <div class="col-xs-6 col-sm-6">
                        <label for="dni">Numero Total de Conceptos</label>
                        <input type="numeric" name="numconcept" id="numconcept" value="{{$cantConcept}}" class="form-control" readonly="readonly">
                    </div>
                </div>
            </div>
            <div class="well pt-4">
                <div class="row">
                    <div class="col-xs-1 col-sm-1 col-md-1">
                        <label for="" class="form-label">Cantidad</label>
                        @for ($i = 0; $i < $cantConcept; $i++)
                            <input type="number" name="CantUnit_{{$i}}" id="CantUnit_{{$i}}" class="form-control text-decoration-none price-input" tabindex="7">
                            <br>
                        @endfor
                    </div>
                    <div class="col-xs-5 col-sm-5 col-md-5">
                        <label for="" class="form-label">Concepto de factura</label>
                        @for ($i = 0; $i < $cantConcept; $i++)
                            <input type="text" name="concept_{{$i}}" id="concept_{{$i}}" class="form-control text-decoration-none" tabindex="7">
                            <br>
                        @endfor
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2">
                        <label for="" class="form-label">Precio Unitario</label>
                        @for ($i = 0; $i < $cantConcept; $i++)
                            <input type="number" name="amountUnit_{{$i}}" id="amountUnit_{{$i}}" class="form-control text-decoration-none price-input" tabindex="7">
                            <br>
                        @endfor
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3">
                        <label for="" class="form-label">Precio del Bien o Servicio</label>
                        @for ($i = 0; $i < $cantConcept; $i++)
                            <input type="number" name="total-amount{{$i}}" id="total-amount{{$i}}" class="form-control text-decoration-none total-amount" tabindex="7" readonly>
                            <br>
                        @endfor
                    </div>
                </div>
            </div>
            <div class="well pb-3 mt-3">
                <button type="submit" class="btn btn-primary" tabindex="6">Siguiente</button>
            </div> 
        </div>
    </div>
  </form>
</div>
@stop

@section('js')
<script>
    $(document).ready(function() {
        $('.price-input').change(function() {
            var index = $(this).attr('id').replace(/[^\d]/g, '');
            var cantidad = $('#CantUnit_'+index).val();
            var precio_unitario = $('#amountUnit_'+index).val();
            var total = cantidad * precio_unitario;
            $('#total-amount'+index).val(total);
        });
    });

</script>
@endsection
