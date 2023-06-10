@extends('adminlte::page')

@section('title', 'Registro de Pago')

@section('content_header')
    <h1>Creacion de  Egreso</h1>
@stop

@section('content')
    <form action="{{route('storepay')}}" method="POST" id="myform">
    @csrf
        <div class="card">
            <div class="card-header">
                
                <h3 class="text-center fw-bolder">Datos del Proveedor</h3>
                @if($errors->first('descriptionseat'))
                    <p class="alert alert-danger" role="alert">{{$errors->first('descriptionseat')}}</p>
                @endif
                @if($errors->first('descriptionseat'))
                    <p class="alert alert-danger" role="alert">{{$errors->first('descriptionseat')}}</p>
                @endif
            </div>
            <div class="card-body pl-6">
                    <input type="hidden" name="idorpa" value="{{$valueIdorpa}}">
                    <input type="hidden" name="idprov" value="{{$valueIdprov}}">
                    <input type="hidden" name="tasa_cambio" value="{{$detPayOrder->tasa_cambio}}">
                    <div class="mb-3">
                        <label for="" class="form-label">Nombre del Proveedor</label>
                        <input type="text" name="name" id="name" value="{{$supplier->nombre}}" class="form-control" readonly="readonly">
                    </div>
                    <div class="well">
                        <div class="row">
                            <div class="col-xs-3 col-sm-6 col-md-4">
                                <div class="form-label">
                                    <label for="dni">Tipo de Identificación</label>
                                    <input type="text" name="tipid" value="{{$supplier->tipid}}" class="form-control" readonly="readonly">
                                </div>
                            </div>
                            <div class="col-xs-3 col-sm-6 col-md-4">
                                <label for="" class="form-label">Rif o Cedula del Proveedor</label>
                                <input type="number" name="identification" value="{{$supplier->identificacion}}" id="identification" class="form-control text-decoration-none" readonly="readonly">
                            </div>
                            @if ($supplier->tiprif != null)
                                <div class="col-xs-3 col-sm-6 col-md-4" id="div-off">
                                    <label for="" class="form-label">Digito Verificador</label>
                                    <input type="text" name="tiprif" value="{{$supplier->tiprif}}" class="form-control" readonly="readonly" readonly="readonly">
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Telefono</label>
                        <input type="text" name="phone" value="{{$supplier->telefono}}" id="phone" class="form-control" readonly="readonly">
                    </div>
                    <div class="mb-3">
                        <label for="" class="well-lg form-label">Dirección</label>
                        <input type="text" name="direction" value="{{$supplier->direccion}}" id="direction" class="form-control" readonly="readonly">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Correo Electronico</label>
                        <input type="text" name="email" id="email" value="{{$supplier->correo}}" class="form-control" readonly="readonly">
                    </div>
                    
                
            </div>
        </div>
        <div class="card"> 
            <div class="card-header">
                <h3 class="text-center fw-bolder">Datos del Pago</h3>
            </div>
            <div class="card-body pl-6">
                <div class="well">
                    <div class="row">
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <label for="" class="form-label">Fecha de Transacción</label>
                            <input type="text" name="fecTransiction" value="{{$fecTransaction}}" id="fecTransiction" readonly="readonly" class="form-control text-decoration-none text-center">
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <label for="" class="form-label">Numero de Confirmación</label>
                            @if($errors->first('numconfirm'))
                                    <p class="text-danger">{{$errors->first('numconfirm')}}</p>
                            @endif
                            <input type="text" name="numconfirm"  id="numconfirm" class="form-control text-decoration-none" tabindex="1">
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <label for="" class="form-label">Numero de factura</label>
                            <input type="text" name="numfact" value="{{$payorder->numfact}}" id="numfact" readonly="readonly" class="form-control text-decoration-none text-center">
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <label for="" class="form-label">Numero de Control de Factura</label>
                            <input type="text" name="numfact" value="{{$payorder->numctrl}}" id="numfact" readonly="readonly" class="form-control text-decoration-none text-center">
                        </div>
                    </div>
                </div>
                <div class="well">
                    <div class="row">
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <label for="" class="">Forma de Pago</label>
                            <select name="formPay" class="custom-select" id="form-pay-select">
                                @foreach ($formPay as $pay)
                                    <option value="{{ $pay->tippago }}">{{ $pay->descripcion }}</option>
                                @endforeach  
                            </select>
                        </div>
                        
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <label for="" class="form-label">Moneda</label>
                            <select name="money" class="custom-select" id="money-select">
                                @foreach ($money as $mon)
                                    <option value="{{ $mon->tipmoneda }}">{{ $mon->descripcion }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="tasa_cambio" value="">

                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <label for="" class="form-label">Monto del Pago</label>
                            @if ($payorder->moneda != 'BS')
                                <input type="text" name="amount" value="{{$detPayOrder->montototallocal}}" id="amount" class="form-control" tabindex="4" readonly="readonly">
                            @else
                                <input type="text" name="amount" value="{{$detPayOrder->montototalmoneda}}" id="amount" class="form-control" tabindex="4" readonly="readonly">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <label for="" class="form-label">Por concepto de</label>
                    @if($errors->first('conceptDesc'))
                        <p class="text-danger">{{$errors->first('conceptDesc')}}</p>
                    @endif
                    <input name="conceptDesc" id="conceptDesc"  class="form-control">
                </div>
                <div class="mt-3">
                    <label for="" class="form-label">Descripcion del Pago</label>
                    @if($errors->first('description'))
                        <p class="text-danger">{{$errors->first('description')}}</p>
                    @endif
                    <textarea name="description" id="description"  class="form-control" ></textarea>
                </div>

            </div>
        </div>
        <div class="well pb-3">
            <a href="{{route('registerpay')}}" class="btn btn-secondary" tabindex="5">Cancelar</a>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#seatmodal">Confirmar</button>
        </div>

        <div class="modal fade" id="seatmodal" tabindex="-1" aria-labelledby="seatmodalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header text-center">
                  <h5 class="modal-title" id="seatmodalLabel">Completar Asiento Contable Final</h5>
                </div>
                <div class="modal-body">
                    <div class="well">
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <h3 class="text-center">Cuenta Debe</h3>
                                  <div class="form-group">
                                  <label for="groupaccount">Grupo de Cuenta</label>
                                  <select name = 'groupaccount1' id ="groupaccount1" class="custom-select">
                                      <option selected="">Seleccionar Grupo</option>
                                  </select>
                                  </div>
                                  <div class="form-group">
                                  <label for="subgroupaccount">Subgrupo de Cuenta</label>
                                  <select name = 'subgroupaccount1' id ="subgroupaccount1" class="custom-select">
                                      <option selected="">Seleccionar Subgrupo</option>
                                  </select>
                                  </div> 
                                  <div class="form-group">
                                  <label for="accountname">Nombre de Cuenta</label>
                                  <select name = 'accountname1'id="accountname1" class="custom-select">
                                      <option selected="">Seleccionar Cuenta</option>
                                  </select>
                                  </div>
                                  <div class="form-group">
                                  <label for="subaccountname">Nombre de Subcuenta</label>
                                  <select name = 'subaccountname1'id="subaccountname1" class="custom-select">
                                      <option selected="">Seleccionar Subcuenta</option>
                                  </select>
                                  <input type="hidden" name="subaccount_tipsubcta1" id="subaccount_tipsubcta1" value="">
                                  <input type="hidden" name="subaccount_descripcion1" id="subaccount_tipsubcta1" value="">
                                  </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <h3 class="text-center">Cuenta Haber</h3>
                                  <div class="form-group">
                                  <label for="groupaccount">Grupo de Cuenta</label>
                                  <select name = 'groupaccount2' id ="groupaccount2" class="custom-select">
                                      <option selected="">Seleccionar Grupo</option>
                                  </select>
                                  </div>
                                  <div class="form-group">
                                  <label for="subgroupaccount">Subgrupo de Cuenta</label>
                                  <select name = 'subgroupaccount2' id ="subgroupaccount2" class="custom-select">
                                      <option selected="">Seleccionar Subgrupo</option>
                                  </select>
                                  </div> 
                                  <div class="form-group">
                                  <label for="accountname">Nombre de Cuenta</label>
                                  <select name = 'accountname2'id="accountname2" class="custom-select">
                                      <option selected="">Seleccionar Cuenta</option>
                                  </select>
                                  </div>
                                  <div class="form-group">
                                  <label for="subaccountname">Nombre de Subcuenta</label>
                                  <select name = 'subaccountname2'id="subaccountname2" class="custom-select">
                                      <option selected="">Seleccionar Subcuenta</option>
                                  </select>
                                  <input type="hidden" name="subaccount_tipsubcta2" id="subaccount_tipsubcta2" value="">
                                  <input type="hidden" name="subaccount_descripcion2" id="subaccount_tipsubcta2" value="">
                                  </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                      <label for="recipient-name" class="col-form-label">Observacion</label>
                      @if($errors->first('observation'))
                        <p class="text-danger">{{$errors->first('observation')}}</p>
                      @endif
                      <input type="text" class="form-control" name="observation" id="observation">
                    </div>
                    <div class="mb-3">
                      <label for="message-text" class="col-form-label">Descripcion</label>
                      @if($errors->first('descriptionseat'))
                      <p class="text-danger">{{$errors->first('descriptionseat')}}</p>
                      @endif
                      <textarea class="form-control" name="descriptionseat" id="descriptionseat"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="confirmAsi('{{ route('storepay') }}')">Guardar</button>

                </div>
              </div>
            </div>
        </div>
    </form>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        var myModal = document.getElementById('myModal')
        var myInput = document.getElementById('myInput')

        myModal.addEventListener('shown.bs.modal', function () {
        myInput.focus()
        })
    </script>
    <script>$( document ).ready(function() 
        {
            cargartipocuenta1()
            $( "#groupaccount1" ).change(function() /* el # busca el id del div html */
            {
                var groupaccount = $('#groupaccount1').val();
                $.ajax(
                {
                  url: "/subgroupaccount1/"+groupaccount,
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
                        var $subgroupaccount = $('#subgroupaccount1');
                        $subgroupaccount.empty();
                        var $accountname = $('#accountname1');
                        $accountname.empty();
                        $subgroupaccount.append('<option selected="">Seleccionar SubGrupo</option>')
                        data.forEach(element=>
                        {
                            $subgroupaccount.append('<option value=' + element.idsgr + '>' + element.descripcion + '</option>')
                        });
                      }
                  }
                });
            });
            $( "#subgroupaccount1" ).change(function() 
            {
                var subgroupaccount = $('#subgroupaccount1').val();
                $.ajax(
                {
                  url: "/accountname1/"+subgroupaccount,
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
                        var $accountname = $('#accountname1');
                        $accountname.empty();
                        var $subaccountname = $('#subaccountname1');
                        $subaccountname.empty();
                        $accountname.append('<option selected="">Seleccionar Cuenta</option>')
                        data.forEach(element=>
                        {
                            $accountname.append('<option value=' + element.idgcu + '>' + element.descripcion + '</option>')
                        });
                      }
                  }
                });
            });
            $( "#accountname1" ).change(function() /* el # busca el id del div html */
            {
                var accountname = $('#accountname1').val();
                $.ajax(
                {
                  url: "/subaccountname1/"+accountname,
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
                        var $subaccountname = $('#subaccountname1');
                        $subaccountname.empty();
                        $subaccountname.append('<option selected="">Seleccionar SubCuenta</option>')
                        data.forEach(element=>
                        {
                            $subaccountname.append('<option value=' + element.idscu + '>' + element.descripcion + '</option>')
                        });
      
                        var values = { 
                            tipsubcta: data[0].tipsubcta,
                            descripcion: data[0].descripcion
                        };
    
                        // Actualizar valores de los inputs
                        $('#subaccount_tipsubcta1').val(values.tipsubcta);
                        $('#subaccount_descripcion1').val(values.descripcion);
                      }
                  }
                });
            });
        });
        function cargartipocuenta1()
        {
          var datas = new FormData();  
          $.ajax({
              url: "/groupaccount1",
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
                    var $groupaccount = $('#groupaccount1');
                    $groupaccount.empty();
                    $groupaccount.append('<option selected="">Seleccionar Grupo</option>');
                    data.forEach(element=>
                    {
                        $groupaccount.append('<option value=' + element.idgru + '>' + element.descripcion + '</option>')
                    });
                  }
                  else
                  {
                    
                  }
                  
              }
          });
      }
      </script>
      <script>$( document ).ready(function() 
        {
            cargartipocuenta2()
            $( "#groupaccount2" ).change(function() /* el # busca el id del div html */
            {
                var groupaccount = $('#groupaccount2').val();
                $.ajax(
                {
                  url: "/subgroupaccount2/"+groupaccount,
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
                        var $subgroupaccount = $('#subgroupaccount2');
                        $subgroupaccount.empty();
                        var $accountname = $('#accountname2');
                        $accountname.empty();
                        $subgroupaccount.append('<option selected="">Seleccionar SubGrupo</option>')
                        data.forEach(element=>
                        {
                            $subgroupaccount.append('<option value=' + element.idsgr + '>' + element.descripcion + '</option>')
                        });
                      }
                  }
                });
            });
            $( "#subgroupaccount2" ).change(function() 
            {
                var subgroupaccount = $('#subgroupaccount2').val();
                $.ajax(
                {
                  url: "/accountname2/"+subgroupaccount,
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
                        var $accountname = $('#accountname2');
                        $accountname.empty();
                        var $subaccountname = $('#subaccountname2');
                        $subaccountname.empty();
                        $accountname.append('<option selected="">Seleccionar Cuenta</option>')
                        data.forEach(element=>
                        {
                            $accountname.append('<option value=' + element.idgcu + '>' + element.descripcion + '</option>')
                        });
                      }
                  }
                });
            });
            $( "#accountname2" ).change(function() /* el # busca el id del div html */
            {
                var accountname = $('#accountname2').val();
                $.ajax(
                {
                  url: "/subaccountname2/"+accountname,
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
                        var $subaccountname = $('#subaccountname2');
                        $subaccountname.empty();
                        $subaccountname.append('<option selected="">Seleccionar SubCuenta</option>')
                        data.forEach(element=>
                        {
                            $subaccountname.append('<option value=' + element.idscu + '>' + element.descripcion + '</option>')
                        });
                        var values = { 
                            tipsubcta: data[0].tipsubcta,
                            descripcion: data[0].descripcion
                        };
    
                        // Actualizar valores de los inputs
                        $('#subaccount_tipsubcta2').val(values.tipsubcta);
                        $('#subaccount_descripcion2').val(values.descripcion);
    
                      }
                  }
                });
            });
        });
        function cargartipocuenta2()
        {
          var datas = new FormData();  
          $.ajax({
              url: "/groupaccount2",
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
                    var $groupaccount = $('#groupaccount2');
                    $groupaccount.empty();
                    $groupaccount.append('<option selected="">Seleccionar Grupo</option>');
                    data.forEach(element=>
                    {
                        $groupaccount.append('<option value=' + element.idgru + '>' + element.descripcion + '</option>')
                    });
                  }
                  else
                  {
                    
                  }
                  
              }
          });
        }
    </script>
    <script>
    
        document.getElementById('money-select').addEventListener('change', function() {
            var formPayValue = document.getElementById('form-pay-select').value;
            var moneyValue = this.value;
    
            if (formPayValue === 'PMO' && moneyValue !== 'BS') {
                alert('No se puede realizar pago móvil en moneda extranjera.');
            }
        });
    </script>
    <script>
        document.getElementById('money-select').addEventListener('change', function() {
            var formPayValue = document.getElementById('form-pay-select').value;
            var selectedOption = this.value;
            if (selectedOption !== 'BS' && formPayValue !== 'PMO') {
                var tasaCambio = prompt('Ingrese la tasa de cambio:');
                document.querySelector('input[name="tasa_cambio"]').value = tasaCambio;
            }
        });
    </script>
    <script>
        function confirmAsi(url) {
            Swal.fire({
                title: 'Confirmación',
                text: '¿Estás seguro de crear Asiento Contable?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('myform').submit(); // Envía el formulario
                }
            });
        }
    </script>
    
    
    
    
@endsection