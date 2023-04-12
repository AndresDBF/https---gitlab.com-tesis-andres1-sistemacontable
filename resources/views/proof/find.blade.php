@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1 class="text-center">Comprobante de Ingreso</h1>
@stop

@section('content')
<div class="container">
  <div class="card">
    <div class="card-body pl-6">
      <h3 class="text-center fw-bolder pb-4">Ingresa la identificacion del Beneficiario de la Factura</h3>
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
                <input type="number" name="identification" id="identification" class="form-control text-decoration-none" tabindex="6">
            </div>
            <div class="col-xs-3 col-sm-6 col-md-4">
                <label for="" class="form-label">Numero de Chequeo</label>
                <select name = 'numcheck' class="custom-select">
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
  </div>
    
  </div>
    <div class="well">
      <div class="row">
        <div class="col-xs-3 col-sm-3 col-md-3">
          <label for="" class="form-label">Numero de Relacion de ingreso</label>
          <input type="text" name="numreling" id="code" class="form-control" readonly="readonly"  tabindex="1">
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3">
          <label for="" class="form-label">fecha de emision</label>
          <input type="text" name="fecemi" id="fecemi"  class="form-control" tabindex="4"  readonly="readonly">
        </div>
        <div class="col-xs-3 col-sm-3 col-md-5">
          <label for="" class="form-label">Nombre y Apellido o Razon Social</label>
          <input type="text" name="name" id="name" class="form-control" readonly="readonly" tabindex="4">
        </div>
      </div>
    </div>
    
    @if(session('error'))
    <div class="alert alert-danger" role="alert">
        {{ session('error') }}
    </div>
    @endif
  </div>
@stop

@section('js')

<!-- Script para manejar la solicitud AJAX -->
<script>
$('#identification').on('change', function() {
    var cedula = $(this).val();
    var tipid = $('select[name="tipid"]').val();
    var tiprif = $('select[name="tiprif"]').val();
    $.ajax({
        type: 'GET',
        url: '/buscar-cedula/' + cedula + '/' + tipid + '/' + tiprif,
        success: function(data) {
            $('#name').val(data.nombre);
            $('#code').val(data.relation);
            $('#fecemi').val(data.fecha_emision);
        }
    });
});
</script>
@endsection