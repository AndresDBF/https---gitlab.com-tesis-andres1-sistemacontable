@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')
    <h1 class="text-secondary fs-5 shadow-lg p-2 mb-5 bg-body rounded text-center">Nuevo Cliente</h1>
@stop

@section('content')
  <form action="/clientes" method="POST">
    @csrf
      <div class="mb-3">
        <label for="" class="form-label">Codigo Cliente</label>
        <input type="text" name="code" id="code" class="form-control" readonly="readonly" value="{{$idsigue}}" tabindex="1">
      </div>
      <div class="well">
        <div class="row">
          <div class="col-xs-3 col-sm-6 col-md-6">
            <label for="" class="form-label">Nombre del Cliente</label>
            <input type="text" name="name" id="name" class="form-control" tabindex="2">
          </div>
          <div class="col-xs-3 col-sm-6 col-md-4">
            <label for="" class="form-label">Rif o Cedula del Cliente</label>
            <input type="number" name="identification" id="identification" class="form-control text-decoration-none" tabindex="3">
          </div>
        </div>
      </div>
      
      <div class="mb-3">
        <label for="" class="form-label">Telefono</label>
        <input type="text" name="phone" id="phone" class="form-control" tabindex="4">
      </div>
      <div class="mb-3">
        <label for="" class="form-label">Correo Electronico</label>
        <input type="text" name="email" id="email" class="form-control" tabindex="5">
      </div>
      <div class="mb-3">
        <label for="" class="well-lg form-label">Dirección</label>
        <input type="text" name="direction" id="direction" class="form-control" tabindex="6">
      </div>
      <br>

      <h1 class="pb-6">Contrato del Cliente</h1>
      <div class="well">
        <div class="row">
          <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
              <label for="dni">Estatus de Contrato</label>
              <select name = 'stscontr' class="custom-select">
                <option selected="">Selecciona el Estatus de contrato</option>
                  <option value="ACT">Activo</option>
              </select>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6 col-md-4">
            <div class="form-group">
              <label for="dni">Tipo de Pago</label>
              <select name = 'tip_pag' class="custom-select">
                <option selected="">Selecciona un tipo de pago</option>
                  <option value="Anual">Anual</option>
                  <option value="Mensual">Mensual</option>
                  <option value="Semestral">Semestral</option>
                  <option value="Trimestral">Trimestral</option>
              </select>
            </div>
          </div>
        </div>
        <div class="well">
          <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
              <label for="" class="form-label">Monto del Contrato</label>
              <input type="number" name="valuecont" id="valuecont" class="form-control" tabindex="7">
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
              <div class="form-group">
                <label for="dni">Moneda</label>
                <select name = 'money' class="custom-select">
                  <option selected="">Selecciona una Moneda</option>
                    <option value="BOL">Bolivares</option>
                    <option value="USD">Dolares</option>
                    <option value="COP">Pesos</option>
                </select>
              </div>
            </div>
          </div>
        </div>

          <div class="form-group">
            <label for="groupaccount">Grupo de Cuenta</label>
            <select name = 'groupaccount' id ="groupaccount" class="custom-select">
                <option selected="">Seleccionar Grupo</option>
                
            </select>
          </div>

          <div class="form-group">
            <label for="subgroupaccount">Subgrupo de Cuenta</label>
            <select name = 'subgroupaccount' id ="subgroupaccount" class="custom-select">
                <option selected="">Seleccionar Subgrupo</option>
            </select>
          </div> 

          <div class="form-group">
            <label for="accountname">Nombre de Cuenta</label>
            <select name = 'accountname'id="accountname" class="custom-select">
                <option selected="">Seleccionar Cuenta</option>
            </select>
          </div>

          <div class="form-group">
            <label for="subaccountname">Nombre de Subcuenta</label>
            <select name = 'subaccountname'id="subaccountname" class="custom-select">
                <option selected="">Seleccionar Subcuenta</option>
            </select>
          </div>

          {{-- <div class="form-group">
            <label for="accounttype">Tipo de Cuenta</label>
            <select name = 'accounttype' id ="accounttype" class="custom-select">
                <option selected="">Selecciona una cuenta</option>
                
            </select>
          </div>

          <div class="form-group">
            <label for="movementtype">Tipo de Movimiento </label>
            <select name = 'movementtype' id ="movementtype" class="custom-select">
                <option selected="">Selecciona una movimiento</option>
            </select>
          </div> 

          <div class="form-group">
            <label for="accountname">Nombre de Cuenta</label>
            <select name = 'accountname'id="accountname" class="custom-select">
                <option selected="">Selecciona Nonbre de Cuenta</option>
            </select>
          </div> --}}
          
      </div>
      <div class="well pb-3">
        <a href="/clientes" class="btn btn-secondary" tabindex="5">Cancelar</a>
        <button type="submit" class="btn btn-primary" tabindex="6">Guardar</button>
      </div>  
  </form> 
  
@stop
<script 
    src="http://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
    crossorigin="anonymous">
</script>
<script>
$( document ).ready(function() 
{
    cargartipocuenta()
    $( "#accounttype" ).change(function() 
    {
        var accounttype = $('#accounttype').val();
        $.ajax(
        {
          url: "/movementtype/"+accounttype,
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          dataType: 'json', // what to expect back from the server                                                                  
          data: {},
          processData: false,
          cache: false,
          contentType: false,
          type: 'post',
          success: function(data) 
          {
              if (data)
              {
                var $movementtype = $('#movementtype');
                $movementtype.empty();
                var $accountname = $('#accountname');
                $accountname.empty();
                data.forEach(element=>
                {
                    $movementtype.append('<option value=' + element.id + '>' + element.descripcion + '</option>')
                });
              }
          }
        });
    });
    $( "#movementtype" ).change(function() 
    {
        var movementtype = $('#movementtype').val();
        $.ajax(
        {
          url: "/accountname/"+movementtype,
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          dataType: 'json', // what to expect back from the server                                                                  
          data: {},
          processData: false,
          cache: false,
          contentType: false,
          type: 'post',
          success: function(data) 
          {
              if (data)
              {
                var $accountname = $('#accountname');
                $accountname.empty();
                data.forEach(element=>
                {
                    $accountname.append('<option value=' + element.id + '>' + element.descripcion + '</option>')
                });
              }
          }
        });
    });
});
function cargartipocuenta()
{
  var datas = new FormData();  
  $.ajax({
      url: "/accounttype",
      dataType: 'json', // what to expect back from the server                                                                  
      data: {},
      processData: false,
      cache: false,
      contentType: false,
      type: 'get',
      success: function(data) 
      {
          if (data)
          {
            var $accounttype = $('#accounttype');
            $accounttype.empty();
            data.forEach(element=>
            {
                $accounttype.append('<option value=' + element.id + '>' + element.descripcion + '</option>')
            });
          }
          else
          {
             
          }
          
      }
  });
}
</script>